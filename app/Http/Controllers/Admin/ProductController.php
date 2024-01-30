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

    // Product list
    public function index(){
        $products = Product::paginate(10);
        $user = auth()->user();
        $ex = explode(" ", $user->name);
        $data = [
            
            'lastName' => end($ex),
            'products' => $products,
        ];

        return view('admin.products.product-list', $data);
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
        $product->price = $request->price;
        $product->status = $request->status;
        $product->product_code = $request->product_code;
        $product->category_id = $request->category_id;
        
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
            notify()->info($product->name. ' has been deleted!');
            $product->delete();

            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
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
            'price' => $request->price,
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