<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                ->orWhereHas('category', function ($q2) use ($search) {
                    $q2->where('title', 'LIKE', "%$search%");
                });
            });
        }

        $products = $query->paginate(10)->withQueryString(); // Preserve query in pagination links
        $all_products = Product::all();

        $user = auth()->user();
        $ex = explode(" ", $user->name);

        return view('admin.products.product-list', [
            'lastName' => end($ex),
            'products' => $products,
            'all_products' => $all_products,
        ]);
    }

    // Product edit view
    public function productEditView(Request $request){
        $product = Product::findOrFail($request->product_id);
        $categories = Category::where('status', 1)->get();
        $view = view('admin.products.partials.edit-product', compact('product','categories'))->render();
        return response()->json([
            'view' => $view,
        ]);
    }

    public function saveProductChanges(Request $request){
        $product = Product::findOrFail($request->product_id);
        $exists = Product::where('name', $request->name)->where('id', '!=', $request->product_id)->first();
        if($exists){
            notify()->info($request->name.' already exist, choose another product name.');
            return back();
        }
        $product->name = $request->name;
        $product->cost_price = $request->cost_price;
        $product->price = $request->price;
        $product->discount_amount = $request->discount_amount;
        $product->discount_percent = $request->discount_percent;
        $product->discount_mode = $request->discount_mode;
        $product->status = $request->status;
        $product->product_code = $request->product_code;
        $product->category_id = $request->category_id;

        // return $product;
        
        if($request->file('pdt_img') != null){
            if(!empty($product->img)){
                unlink(public_path('uploads/'. $product->img));
            }
            
            $image = $request->file('pdt_img');
            $imageName = time() . '.' . $image->extension();
            $img = Image::make($image->path());
            $img->resize(90, 90);
            $img->save(public_path('uploads/' . $imageName));
            $product->img = $imageName;
            $compressedImageSize = filesize(public_path('uploads/' . $imageName));
        }else{
            $product->img = $product->img;
        }
        
        $product->save();
        
        notify()->success('Changes saved successfully!');
        return back();
    }

    public function deleteProduct($id){
        try{
            $product = Product::findOrFail($id);
            $productName = $product->name;
            
            // Check if product is referenced in orders
            $orderCount = \App\Models\Order::where('product_id', $id)->count();
            if($orderCount > 0) {
                notify()->error("Cannot delete '{$productName}'. This product is referenced in {$orderCount} order(s). Consider setting status to 'Unavailable' instead.");
                return back();
            }
            
            // Check if product is referenced in cart
            $cartCount = \App\Models\Cart::where('product_id', $id)->count();
            if($cartCount > 0) {
                notify()->error("Cannot delete '{$productName}'. This product is currently in {$cartCount} active cart(s). Please remove from carts first.");
                return back();
            }
            
            // Check if product has stock requests
            $stockCount = \App\Models\Stock::where('product_id', $id)->count();
            if($stockCount > 0) {
                notify()->error("Cannot delete '{$productName}'. This product has {$stockCount} stock request(s). Consider setting status to 'Unavailable' instead.");
                return back();
            }
            
            // Check if product has availability > 0
            if($product->availability > 0) {
                notify()->warning("Warning: Deleting '{$productName}' with {$product->availability} items in stock. This will result in inventory loss.");
            }
            
            // Delete product image if exists
            if(!empty($product->img) && file_exists(public_path('uploads/'. $product->img))) {
                unlink(public_path('uploads/'. $product->img));
            }
            
            $product->delete();
            notify()->success("'{$productName}' has been successfully deleted!");
            
            return back();
        }catch(Exception $e){
            notify()->error('Error deleting product: ' . $e->getMessage());
            return back();
        }
    }

    // Product add view
    public function productAddView(){
        try{
            $categories = Category::where('status', 1)->get();

            $view = view('admin.products.partials.add-product', compact('categories'))->render();
            return response()->json([
                'view' => $view,
            ]);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    // Product add view
    public function productAddMultipleView(){
        try{
            $categories = Category::where('status', 1)->get();

            $view = view('admin.products.partials.add-multiple-product', compact('categories'))->render();
            return response()->json([
                'view' => $view,
            ]);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function addProduct(Request $request){
        $exists = Product::where('name', $request->name)->orWhere('product_code', $request->product_code)->first();
        if($exists){
            notify()->error($request->name.' already exist. Multiple products cannot have the same NAME or PRODUCT CODE!');
            return back();
        }

       if($request->file('pdt_img') != null){
            $image = $request->file('pdt_img');
            $imageName = time() . '.' . $image->extension();
            $img = Image::make($image->path());
            $img->resize(90, 90);
            $img->save(public_path('uploads/' . $imageName));
            $compressedImageSize = filesize(public_path('uploads/' . $imageName));
        }else{
            $imageName = null;
        }

        Product::create([
            'name' => $request->name,
            'cost_price' => $request->cost_price,
            'price' => $request->price,
            'discount_mode' => $request->discount_mode,
            'discount_amount' => $request->discount_amount,
            'discount_percent' => $request->discount_percent,
            'status' => $request->status,
            'product_code' => $request->product_code,
            'category_id' => $request->category_id,
            'img' => $imageName,
        ]);

        notify()->success($request->name.' successfully added!');
        return back();
    }


    // List product categories

    public function listCategories(){
        $user = auth()->user();
        $ex = explode(" ", $user->name);
        $categories = Category::paginate(10);
        $data = [
            'lastName' => end($ex),
            'categories' => $categories,
        ];

        return view('admin.products.category-list', $data);
    }


    // Category edit view
    public function categoryEditView(Request $request){
        try{
            $category = Category::where('id', $request->category_id)->first();
            $view = view('admin.products.partials.edit-category', compact('category'))->render();
            
            return response()->json([
                'view' => $view,
            ]);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    // Category add view
    public function categoryAddView(){
         try{
            $view = view('admin.products.partials.add-category')->render();
            return response()->json([
                'view' => $view,
            ]);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function saveCategoryChanges(Request $request){
        try{
            $category = Category::findOrFail($request->category_id);
            $exists = Category::where('title', $request->title)->where('id', '!=', $request->category_id)->first();
            if($exists){
                notify()->info($request->name.' already exist, choose another product name.');
                return back();
            }
            $category->title = $request->title;
            $category->status = $request->status;
            $category->save();

            notify()->success($request->title. ' successfully updated!');
            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();

        }
    }


    public function deleteCategory($id){
        try{
            $category = Category::findOrFail($id);
            notify()->info($category->title. ' successfully deleted!');
            $category->delete();
            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }


    public function addCategory(Request $request){
        try{
            $user = auth()->user();
            $category = new Category();
            $category->user_id = $user->id;
            $category->title = $request->title;
            $category->status = $request->status;
            $category->save();

            notify()->success('Category successfully created!');
            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }
    
}