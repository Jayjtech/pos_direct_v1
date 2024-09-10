<?php

namespace App\Http\Controllers\Shop;

use Exception;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function addToCart(Request $request){
        
        try{
            $user = auth()->user();
            $product = Product::findOrFail($request->product_id);
            
            // 0: Active cart
            // 1: Saved Cart
            $checkIfActiveCartExist = Cart::where('user_id', $user->id)
                                            ->where('status',0)->first();
                
            if(!$checkIfActiveCartExist){
                // If there is no active cart, create a new cart_report for the new TAB
                $invoice_code = strtolower(Str::random(5)).substr(time(), 0, 3);
                $cart_report = CartReport::create(["user_id" => $user->id, "invoice_code" => $invoice_code]);
                $cart_report_id = $cart_report->id;
            }else{
                // Else keep using the old cart_report_id
                $cart_report_id = $checkIfActiveCartExist->cart_report_id;
            }

            $checkIfProductExist = Cart::where('cart_report_id', $cart_report_id)
                                        ->where('user_id', $user->id)
                                        ->where('product_id', $product->id)->first();
            
            if(!$checkIfProductExist){
                // If product does not already exist in cart
                Cart::create([
                    "user_id" => $user->id,
                    "product_id" => $product->id,
                    "cart_report_id" => $cart_report_id,
                    "qty" => 1,
                    "price" => $product->price,
                    "sub_total" => $product->price, //On creation, sub_total = price
                    "discount" => 0,
                    "checkbox_status" => "unchecked",
                    "pdt_discount" => $product->discount_mode == 0 ? $product->discount_amount: ($product->price*($product->discount_percent/100))
                ]);

                $response = [
                    'status' => 1,
                    'icon' => 'success',
                    'message' => '<strong>'.$product->name . '</strong> has been added to cart!'
                ];
                
            }else{
                $response = [
                    'status' => 100,
                    'icon' => 'info',
                    'message' => '<strong>'.$product->name . '</strong> already exist in cart!'
                ];
            }

            // Update cart report
            $grand_total = Cart::where('cart_report_id', $cart_report_id)->sum('sub_total');
            CartReport::where('id', $cart_report_id)->update(["grand_total" => $grand_total]);
            
            // Fetch Active Cart
            $active_cart = Cart::where('cart_report_id', $cart_report_id)
                                ->where('user_id', $user->id)->get();
            // Payment Method 
            $pm_method = CartReport::where('id',$cart_report_id)->first();
            $active_cart_id = $cart_report_id;
        }catch(Exception $e){
            if($e->getMessage()){
                $response = [
                    'status' => 1,
                    'icon' => 'danger',
                    'message' => $e->getMessage()
                ];
            }
        }

        // return $response;
         // Fetch Tabs except current tab
        $tabs = CartReport::where('user_id', $user->id)
                            ->where('id', '!=', $cart_report_id)
                            ->get();
        $pm_method_view = view('shop.partials.payment_methods', compact('pm_method','active_cart_id'))->render();
        
        $view = view('shop.partials.cart_display', compact('active_cart'))->render();
        $tab_view = view('shop.partials.tab', compact('tabs','active_cart_id'))->render();
        return response()->json([
                    'html' => $view,
                    'tab_view' => $tab_view,
                    'pm_method_view' => $pm_method_view,
                    'json' => $response,
                    'variety' => $active_cart->count(),
                    'grand_total' => $grand_total,
                    'active_tab' => $cart_report_id
                ]);
                
    }

    // Remove product from cart
    public function removeFromCart(Request $request){
        try{
            $user = auth()->user();
            $cart_row = Cart::where('id', $request->cartRowId)->first();
            Cart::where('id', $request->cartRowId)->delete();
            
            // Check if item is the only one left
            $check = Cart::where('cart_report_id', $cart_row->cart_report_id)->get();
            if($check->count() == 0){
                CartReport::where('id', $cart_row->cart_report_id)->delete();
                $grand_total = 0;
            }else{
                // Update cart report
                $grand_total = Cart::where('cart_report_id', $cart_row->cart_report_id)->sum('sub_total');
                CartReport::where('id', $cart_row->cart_report_id)->update(["grand_total" => $grand_total]);
            }
            
            // Fetch Active Cart
            $active_cart = Cart::where('status',0)
                                    ->where('user_id', $user->id)->get();
            $response = [
                'status' => 1,
                'icon' => 'danger',
                'message' => '<strong>'.$cart_row->product->name . '</strong> has been removed from cart!'
            ];

        }catch(Exception $e){
            if($e->getMessage()){
                $response = [
                    'status' => 1,
                    'icon' => 'danger',
                    'message' => $e->getMessage()
                ];
            }
        }

        $view = view('shop.partials.cart_display', compact('active_cart'))->render();
        return response()->json([
            'html' => $view,
            'json' => $response,
            'variety' => $active_cart->count(),
            'grand_total' => $grand_total
        ]);

    }

    // Change Quantity
    public function changeQty(Request $request){
        try{
            $user = auth()->user();
            $cart_row = Cart::findOrFail($request->id);

            $cart_row->qty = $request->qty;
            if($request->qty > $cart_row->product->availability){
                $response = [
                    'status' => 1,
                    'icon' => 'warning',
                    'message' => 'Only <strong> '.$cart_row->product->availability . 'unit </strong>  of <strong>'.$cart_row->product->name . '</strong> is left in store!'
                ];
            }else{
                if(floatval($request->qty) < 0.1){
                    $response = [
                        'status' => 1,
                        'icon' => 'warning',
                        'message' => '<strong>'.$cart_row->product->name . '</strong> quantity cannot be equal to <strong>0</strong>!'
                    ];
                }else{
                    if(companyInfo()->discount_mode == 0){ // By Amount
                        $discount = ($cart_row->qty*$cart_row->discount);
                    }else{ // By percentage
                        $discount = ($cart_row->qty*$cart_row->product->price)*($cart_row->discount/100);
                    }
                    $cart_row->sub_total = ($request->qty*$cart_row->product->price)-($discount);
                    $cart_row->save();

                    $response = [
                        'status' => 1,
                        'icon' => 'success',
                        'message' => '<strong>'.$cart_row->product->name . '</strong> quantity successfully updated to <strong>'.$request->qty.'</strong>!'
                    ];
                }
            }
            
            
            // Update cart report
            $grand_total = Cart::where('cart_report_id', $cart_row->cart_report_id)->sum('sub_total');
            CartReport::where('id', $cart_row->cart_report_id)->update(["grand_total" => $grand_total]);

            // Fetch Active Cart
            $active_cart = Cart::where('cart_report_id', $cart_row->cart_report_id)
                                    ->where('user_id', $user->id)->get();
            
        }catch(Exception $e){
            if($e->getMessage()){
                $response = [
                    'status' => 1,
                    'icon' => 'danger',
                    'message' => $e->getMessage()
                ];
            }
        }

        $view = view('shop.partials.cart_display', compact('active_cart'))->render();
        return response()->json([
            'html' => $view,
            'json' => $response,
            'variety' => $active_cart->count(),
            'grand_total' => $grand_total
        ]);
    }

    // Change Discount
    public function changeDiscount(Request $request){
        try{
            $user = auth()->user();
            $checkbox_status = $request->status ?? $request->status;
            
            $cart_row = Cart::findOrFail($request->id);

            $cart_row->discount = ($cart_row->qty*$request->discount); //Update the discount column
            if(companyInfo()->discount_visibility == 1){
                $discount = ($cart_row->qty*$request->discount);
            }else if(companyInfo()->discount_visibility == 0 && companyInfo()->discount_mode == 0){ // By Amount
                $discount = ($cart_row->qty*$request->discount);
            }else{ // By percentage
                $discount = ($cart_row->qty*$cart_row->product->price)*($request->discount/100);
            }
            
            $cart_row->sub_total = ($cart_row->qty*$cart_row->product->price)-($discount); //Deduct discount
            $cart_row->checkbox_status = $checkbox_status;
            $cart_row->save();

            // Update cart report
            $grand_total = Cart::where('cart_report_id', $cart_row->cart_report_id)->sum('sub_total');
            CartReport::where('id', $cart_row->cart_report_id)->update(["grand_total" => $grand_total]);

            // Fetch Active Cart
            $active_cart = Cart::where('cart_report_id', $cart_row->cart_report_id)
                                    ->where('user_id', $user->id)->get();
            $response = [
                'status' => 1,
                'icon' => 'info',
                'message' => 'Discount of <strong>'.$discount.'</strong> has be given for <strong>'.$cart_row->product->name .'</strong>!'
            ];
        }catch(Exception $e){
            if($e->getMessage()){
                $response = [
                    'status' => 1,
                    'icon' => 'danger',
                    'message' => $e->getMessage()
                ];
            }
        }

        $view = view('shop.partials.cart_display', compact('active_cart', 'checkbox_status'))->render();
        return response()->json([
            'html' => $view,
            'json' => $response,
            'variety' => $active_cart->count(),
            'grand_total' => $grand_total
        ]);
    }

    // Add checkout method
    public function addCheckoutMethod(Request $request){
        try{
            $user = auth()->user();
            CartReport::where('id', $request->cart_report_id)->update(["payment_method" => $request->checkout_method]);
            // Update cart report
            $method = paymentMethod($request->checkout_method);
             // Payment Method 
            $pm_method = CartReport::where('id', $request->cart_report_id)->first();
            $active_cart_id = $request->cart_report_id;
            
            $response = [
                'status' => 1,
                'icon' => 'success',
                'message' => '<strong>'.$method.'</strong> payment method saved!<strong>!'
            ];
            $pm_method_view = view('shop.partials.payment_methods', compact('pm_method','active_cart_id'))->render();

        }catch(Exception $e){
            if($e->getMessage()){
                $response = [
                    'status' => 1,
                    'icon' => 'danger',
                    'message' => $e->getMessage()
                ];
            }
        }
        
        return response()->json([
            'json' => $response,
            'pm_method_view' => $pm_method_view,
            'active_cart_id' => $active_cart_id
        ]);
    }

    
    // Create new tab
    public function createNewTab(Request $request){
        try{
            $user = auth()->user();
            // Get grand total
            $getTotal = Cart::where('cart_report_id', $request->active_tab)->sum('sub_total');
            
            $checkNumTabs = CartReport::where('user_id', $user->id)->get();
            $checkIfExistActiveTab = Cart::where('user_id', $user->id)
                                            ->where('status', 0)->get();
            if($checkIfExistActiveTab->count() == 0){
                $response = [
                    'status' => 1,
                    'icon' => 'info',
                    'message' => '<strong>New cart already created, kindly add the products!</strong>'
                ];

                $grand_total = 0;
            }else{
                if($checkNumTabs->count() <= 10){
                    $savePreviousCart = Cart::where('cart_report_id', $request->active_tab)
                                            ->where('user_id', $user->id)        
                                            ->update(["status" => 1]);
                    if($savePreviousCart){
                        $response = [
                            'status' => 1,
                            'icon' => 'success',
                            'message' => 'Previous cart successfully saved and new cart created!'
                        ];

                        $grand_total = 0;
                    }else{
                        $response = [
                            'status' => 1,
                            'icon' => 'danger',
                            'message' => 'Internal error, contact developer!'
                        ];
                        $grand_total = $getTotal;
                    }
                }else{
                    $response = [
                        'status' => 1,
                        'icon' => 'info',
                        'message' => '<strong>Tab limit reached.</strong> You can only save 4 tabs!'
                    ];
                    $grand_total = $getTotal;
                }
            }
            
            
            // Fetch Active Cart
            $active_cart = Cart::where('status', 0)
                                ->where('user_id', $user->id)->get();
            // Fetch Tabs 
            $tabs = CartReport::where('user_id', $user->id)->get();
            // Payment Method 
            $pm_method = (object) [
                "id" => "", 
                "buyer" => "", 
                "phone" => "",
                "address" => "", 
                "payment_method" => 0
            ]; // Payment method has not been added;
            $active_cart_id = 0;
        }catch(Exception $e){
           if($e->getMessage()){
                $response = [
                    'status' => 1,
                    'icon' => 'danger',
                    'message' => $e->getMessage()
                ];
            } 
        }

        $pm_method_view = view('shop.partials.payment_methods', compact('pm_method','active_cart_id'))->render();
        $view = view('shop.partials.cart_display', compact('active_cart'))->render();
        $tab_view = view('shop.partials.tab', compact('tabs','active_cart_id'))->render();
        return response()->json([
            'html' => $view,
            'tab_view' => $tab_view,
            'json' => $response,
            'pm_method_view' => $pm_method_view,
            'variety' => $active_cart->count(),
            'grand_total' => $grand_total
        ]);
    }


    // Tab Requests
    public function tabRequest(Request $request){
        try{
            $request = (object) $request->all();
            $user = auth()->user();
            
            if(!empty($request->tab_id)){
                $status = 0; //Active
                $tab_id = $request->tab_id;
            }else if(!empty($request->invoice_code)){
                $status = 2; // Active and searched by admin
                $invoice = CartReport::where('invoice_code', $request->invoice_code)->first();
                if(!$invoice){
                    return [
                        'error' => true,
                        'status' => 1,
                        'icon' => 'danger',
                        'message' => "Invalid invoice code!"
                    ];
                }else{
                    $tab_id = $invoice->id;
                }
            }

            $buyer = CartReport::where('id', $tab_id)->pluck('buyer')[0];
        
            if($request->query == "view"){
                
                // View tab
                $deactivateOtherCarts = Cart::where('user_id', $user->id)
                                            ->where('cart_report_id', '!=', $tab_id)
                                            ->update(["status" => 1]);

                // Update Cart
                $activateSelectedTab = Cart::where('cart_report_id', $tab_id)->update(["status" => $status]); 
                
                
                // Get grand total
                $grand_total = Cart::where('cart_report_id', $tab_id)->sum('sub_total');

                $response = [
                    'status' => 1,
                    'icon' => 'info',
                    'message' => "You switched to <strong>".$buyer."'s</strong> tab!"
                ];
            }else if($request->query == "delete"){
                // Delete tab
                CartReport::where('id', $tab_id)->delete();
                // Get grand total
                $grand_total = Cart::where('status', 0)
                                    ->where('user_id', $user->id)
                                    ->sum('sub_total');
                $response = [
                    'status' => 1,
                    'icon' => 'info',
                    'message' => "You deleted <strong>".$buyer."'s</strong> tab!"
                ];
            }
            

                // Fetch Active Cart
                if($status == 0){
                    // Search with user ID
                    $active_cart = Cart::where('status', $status)
                                ->where('user_id', $user->id)->get();
                }else if($status == 2){
                    // Don't search with user ID
                    $active_cart = Cart::where('status', $status)->get();
                }
                
                if($active_cart->count() != 0){
                    $active_tab = $active_cart[0]->cart_report_id;
                }else{
                    $getFirstCartReport = CartReport::where('user_id', $user->id)->first();
                    if($getFirstCartReport->count() != 0){
                        // Activate the first tab available
                        Cart::where('cart_report_id', $getFirstCartReport->id)->update(["status" => 0]);

                        // Fetch the activated cart
                        $active_cart = Cart::where('status', 0)
                                    ->where('user_id', $user->id)->get();
                        $active_tab = $active_cart[0]->cart_report_id;
                    }
                }
            
            // // Fetch Tabs except current tab
            $tabs = CartReport::where('user_id', $user->id)
                                ->where('id', '!=', $active_tab)
                                ->get();
             // Payment Method 
            $pm_method = CartReport::where('id', $active_tab)->first();
            $active_cart_id = $active_tab;
            // return $tabs;
        }catch(Exception $e){
            if($e->getMessage()){
                $response = [
                    'status' => 1,
                    'icon' => 'danger',
                    'message' => $e->getMessage()
                ];
            } 
        }

        // return $response;
        $pm_method_view = view('shop.partials.payment_methods', compact('pm_method','active_cart_id'))->render();
        $view = view('shop.partials.cart_display', compact('active_cart',))->render();
        $tab_view = view('shop.partials.tab', compact('tabs','active_cart_id'))->render();
        return response()->json([
            'html' => $view,
            'tab_view' => $tab_view,
            'json' => $response,
            'pm_method_view' => $pm_method_view,
            'variety' => $active_cart->count(),
            'grand_total' => $grand_total,
            'active_tab' => $active_tab
        ]);
    }


    // Add buyer's name
    public function addBuyerName(Request $request){
        try{
            if(strlen($request->buyer) > 20){
               return response()->json([
                    'status' => 0,
                    'icon' => 'danger',
                    'message' => "<strong>Name length should not be more than 20 letters!</strong>"
                ]); 
            }

            $user = auth()->user();
            $active_cart = Cart::where('status', 0)->where('user_id', $user->id)->get();
            $active_cart_id = $active_cart[0]->cart_report_id;

            CartReport::where('id', $active_cart_id)->update(["buyer" => htmlspecialchars($request->buyer)]);

            // Fetch Tabs except current tab
            $tabs = CartReport::where('user_id', $user->id)
                                ->where('id', '!=', $active_cart_id)
                                ->get();
            // Payment Method 
            $pm_method = CartReport::where('id', $active_cart_id)->first();

            $response = [
                'status' => 1,
                'icon' => 'success',
                'message' => "Cart owner successfully saved as <strong>".$request->buyer."</strong>!"
            ];

        }catch(Exception $e){
              if($e->getMessage()){
                $response = [
                    'status' => 1,
                    'icon' => 'danger',
                    'message' => $e->getMessage()
                ];
            } 
        }

        $pm_method_view = view('shop.partials.payment_methods', compact('pm_method','active_cart_id'))->render();
        $view = view('shop.partials.cart_display', compact('active_cart',))->render();
        $tab_view = view('shop.partials.tab', compact('tabs','active_cart_id'))->render();
        return response()->json([
            'html' => $view,
            'tab_view' => $tab_view,
            'json' => $response,
            'pm_method_view' => $pm_method_view,
            'variety' => $active_cart->count(),
        ]);
    }

    // Add buyer info
    public function addBuyerInfo(Request $request){
        try{
            $tab = CartReport::findOrFail($request->tab_id);
            $tab->buyer = $request->buyer;
            $tab->phone = $request->phone;
            $tab->address = $request->address;
            $tab->save();

            notify()->success($tab->buyer ."'s information successfully saved!");
        }catch(Exception $e){
            if($e->getMessage()){
                notify()->error($e->getMessage());
            } 
        }

        return back();
    }

    
    // End of controller
}