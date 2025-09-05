<?php

namespace App\Http\Controllers\Shop;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\CartReport;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Load Shop
    public function index(){
        $user = auth()->user();
        $products = Product::where('status',1)
                            ->where('availability', '>', 0)
                            ->paginate(12);
            
        $ex = explode(" ", $user->name);
        // Fetch Active Cart
        $active_cart = Cart::where('status',0)
                                ->where('user_id', $user->id)->get();

            if($active_cart->count() != 0){
                $active_tab = $active_cart[0]->cart_report_id;
            }else{
                $getFirstCartReport = CartReport::where('user_id', $user->id)->first();
                // return $getFirstCartReport;
                if($getFirstCartReport != null){
                    // Activate the first tab available
                    Cart::where('cart_report_id', $getFirstCartReport->id)->update(["status" => 0]);

                    // Fetch the activated cart
                    $active_cart = Cart::where('status', 0)
                                ->where('user_id', $user->id)->get();
                    $active_tab = $active_cart[0]->cart_report_id;
                }else{
                    $active_tab = 0;
                }
            }
             // Payment Method 
            $pm_method = CartReport::where('id',$active_tab)->first();
            // Fetch Tabs except current tab
            $tabs = CartReport::where('user_id', $user->id)
                                ->where('id', '!=', $active_tab)
                                ->get();

        $data = [
            'lastName' => end($ex),
            'products' => $products,
            'active_cart' => $active_cart,
            'active_cart_id' => $active_tab,
            'tabs' => $tabs,
            'pm_method' => $pm_method
        ];

        return view('shop.shop', $data);
    }

    // Search Product
    public function searchProduct(Request $request){
        try{
            if(empty($request->search)){
                $products = Product::where('status', 1)
                            ->where('availability', '>', 0)->paginate(12);
            }else{
                $products = Product::where('name', 'like', '%'.$request->search.'%')
                            ->where('status', 1)
                            ->where('availability', '>', 0)
                            ->orWhere('price','like', '%'.$request->search.'%')
                            ->orderBy('id', 'desc')->paginate(12);
            }
            
            if($products->count() >= 1){
                return view('shop.partials.paginate_products', compact('products'))->render();
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'Search not found!'
                ]);
            }
        }catch(Exception $e){
            if($e->getMessage()){
                return response()->json([
                    'status' => 0,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    // Paginate Products
    public function paginateProduct(Request $request){
        $products = Product::where('status', 1)
                            ->where('availability', '>', 0)
                            ->paginate(12);
                            
        return view('shop.partials.paginate_products', compact('products'));
    }

    // Print Receipt
    public function generateReceipt($id){
        try{
            $user = auth()->user();
            $tab = CartReport::findOrFail($id);
            $payment_method = paymentMethod($tab->payment_method);
            
            // Move request from cart to orders table. Also save combined order in db
            $check = CombinedOrder::where('trx_id', $tab->invoice_code)
            ->where('user_id', $user->id)->first();
            if(!$check){
                $saveCombinedOrder = CombinedOrder::create([
                    "buyer_details" => json_encode([
                        "buyer" => $tab->buyer,
                        "phone" => $tab->phone,
                        "address" => $tab->address,
                        "payment_method" => $payment_method,
                    ]),
                    "payment_method" => $tab->payment_method,
                    "trx_id" => $tab->invoice_code,
                    "user_id" => $user->id,
                    "grand_total" => $tab->grand_total,
                    "status" => 1 //Completed
                ]);
            }

            foreach($tab->cart as $cart){
                $single_order = new Order();
                $single_order->combined_order_id = $saveCombinedOrder->id;
                $single_order->user_id = $user->id;
                $single_order->product_id = $cart->product_id;
                $single_order->product = $cart->product->name;
                $single_order->product_code = $cart->product->product_code;
                $single_order->barcode = $cart->product->product_barcode;
                $single_order->qty = $cart->qty;
                $single_order->unit_price = $cart->price;
                $single_order->sub_cost_price = $cart->product->cost_price*$cart->qty;
                $single_order->sub_selling_price = $cart->product->price*$cart->qty;
                $single_order->sub_total =  getSubTotal($cart->qty,$cart->product->price,$cart->discount);
                $single_order->discount = $cart->discount;
                $single_order->status = 1; // Completed
                // Save each in the orders table
                $single_order->save();

                // Subtract quantity from availability on products tbl
                $prod = Product::findOrFail($cart->product_id);
                $prod->availability -= $cart->qty;
                $prod->save();
            }

            notify()->success($tab->buyer ."'s order successfully saved!"); 
            // Delete the tab and cart
            $tab->delete();
            
            // Redirect with Combined order ID to the receipt page
            return redirect()->route('view.receipt',$saveCombinedOrder->id);
            
        }catch(Exception $e){
            if($e->getMessage()){
                notify()->error($e->getMessage());
                return back();
            }
        }
    }

}