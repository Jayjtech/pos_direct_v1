<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orderList(){
       try{
            $startDate = date("Y-m-d");
            $endDate = date("Y-m-d");
            $user = auth()->user();
            $ex = explode(" ", $user->name);
            if($user->can('order-report')){
                $combined_orders = CombinedOrder::where('status', '!=', 2)
                                ->whereDate('updated_at', $startDate)
                                ->paginate(10);
                $grand_total = CombinedOrder::where('status','!=',2)
                                ->whereDate('updated_at', $startDate)
                                ->sum('grand_total');
            }else{
                $combined_orders = CombinedOrder::where('user_id', $user->id)
                                ->whereDate('updated_at', $startDate)
                                ->where('status', '!=', 2)
                                
                                ->paginate(10);
                $grand_total = CombinedOrder::where('user_id', $user->id)
                                ->whereDate('updated_at', $startDate)
                                ->where('status','!=',2)
                                ->sum('grand_total');
            }
            
            $data = [
                'combined_orders' => $combined_orders,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'grand_total' => $grand_total,
                'lastName' => end($ex)
            ];

            return view('admin.orders.order-list', $data);
       }catch(Exception $e){
            notify()->warning($e->getMessage());
            return back();
       }

    }

    public function refundedOrderList(){
       try{
            $startDate = date("Y-m-d");
            $endDate = date("Y-m-d");
            $user = auth()->user();
            $ex = explode(" ", $user->name);
            if($user->can('order-report')){
                $combined_orders = CombinedOrder::where('status', '=', 2)
                                ->whereDate('updated_at', $startDate)
                                ->paginate(10);
                $grand_total = CombinedOrder::where('status','=',2)
                                ->whereDate('updated_at', $startDate)
                                ->sum('grand_total');
            }else{
                $combined_orders = CombinedOrder::where('user_id', $user->id)
                                ->whereDate('updated_at', $startDate)
                                ->where('status', '=', 2)
                                
                                ->paginate(10);
                $grand_total = CombinedOrder::where('user_id', $user->id)
                                ->whereDate('updated_at', $startDate)
                                ->where('status','=',2)
                                ->sum('grand_total');
            }
            
            $data = [
                'combined_orders' => $combined_orders,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'grand_total' => $grand_total,
                'lastName' => end($ex)
            ];

            return view('admin.orders.refunded-orders', $data);
       }catch(Exception $e){
            notify()->warning($e->getMessage());
            return back();
       }
    }

    public function refundOrderView(Request $request){
        try{
            $sub = CombinedOrder::findOrFail($request->order_id);
            $view = view('admin.orders.partials.refund-order', compact('sub'))->render();
            return response()->json([
                'view' => $view,
            ]);
        }catch(Exception $e){
            return response()->json([
                    'error' => $e->getMessage()
            ]);
        }
    }

    public function revokeOrderView(Request $request){
        try{
            $sub = CombinedOrder::findOrFail($request->order_id);
            $view = view('admin.orders.partials.revoke-order', compact('sub'))->render();
            return response()->json([
                'view' => $view,
            ]);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function refundOrder(Request $request){
        try{
            if(!$request->orders){
                notify()->warning('You did not check any order!');
                return back();
            }
            
            foreach($request->orders as $order_id){
                // Select order which has not been refunded before
                $order = Order::where('id', $order_id)->where('status', '!=', 2)->first();
                if($order){
                    // Return product to store
                    $product = Product::where('id', $order->product_id)->first();
                    $product->availability += $order->qty;
                    $product->save();
                    // Save Order
                    $order->status = 2;
                    $order->save();
                }
            }
            
                // Check if there is still an order not refunded
                $orders = Order::where('combined_order_id', $request->combined_order_id)->where('status', '!=', 2)->get();
                
                $combined_order = CombinedOrder::findOrFail($request->combined_order_id);
                $combined_order->grand_total = Order::where('combined_order_id', $request->combined_order_id)->where('status', '!=', 2)->sum('sub_total');

                if($orders->count() == 0){
                    $combined_order->status = 2;
                    $combined_order->save();
                    return back();
                    notify()->success('Order successfully refunded!');
                }else{
                    notify()->success('Checked orders successfully refunded!');
                    $combined_order->save();
                    return back();
                }
            
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return $e->getMessage();
            return back();
        }
    }

    // Revoke refunded order
    public function revokeOrder(Request $request){
        try{
            if(!$request->orders){
                notify()->warning('You did not check any order!');
                return back();
            }

            foreach($request->orders as $order_id){
                // Select order which has not been revoked before
                $order = Order::where('id', $order_id)->where('status', '!=', 1)->first();
                if($order){
                    // Take product back to order
                    // Return product to store
                    $product = Product::where('id', $order->product_id)->first();
                    $product->availability -= $order->qty;
                    $product->save();
                    // Update order
                    $order->status = 1;
                    $order->save();
                }
            }
                // Check if there is still an order not revoked
                $orders = Order::where('combined_order_id', $request->combined_order_id)->where('status', '!=', 1)->get();
                
                $combined_order = CombinedOrder::findOrFail($request->combined_order_id);
                $combined_order->grand_total = Order::where('combined_order_id', $request->combined_order_id)->where('status', '!=', 2)->sum('sub_total');

                if($orders->count() == 0){
                    notify()->success('Order successfully revoked and returned to store!');
                }else{
                    notify()->success('Checked orders successfully revoked and all has others have been moved to order table!');
                }

                $combined_order->status = 1; //Return order to order table
                $combined_order->save();
            
            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }

    public function revokeSingleOrder($order_id, $combined_order_id){
        try{
            $order = Order::where('id', $order_id)->where('status', '!=', 1)->first();
            if($order){
                // Take product back to order
                $product = Product::where('id', $order->product_id)->first();
                $product->availability -= $order->qty;
                $product->save();
                // Update order
                $order->status = 1;
                $order->save();

                $combined_order = CombinedOrder::findOrFail($combined_order_id);
                $combined_order->grand_total = Order::where('combined_order_id', $combined_order_id)->where('status', '!=', 2)->sum('sub_total');
                $combined_order->save();
                notify()->success('Order successfully revoked and returned to store!');
                return back();
            }
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }

    public function searchOrder(Request $request){
        try{
            $user = auth()->user();
            $ex = explode(" ", $user->name);

            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if($startDate == $endDate){
                if($user->can('order-report')){
                $combined_orders = CombinedOrder::where('status','!=',2)
                                                    ->whereDate('created_at', $startDate)
                                                    ->paginate(10)
                                                    ->appends(['startDate' => $startDate, 'endDate' => $endDate]);
                    $grand_total = CombinedOrder::where('status','!=',2)
                                                    ->whereDate('created_at', $startDate)
                                                    ->sum('grand_total');
                }else{
                $combined_orders = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                    ->whereDate('created_at', $startDate)
                                                    ->paginate(10)
                                                    ->appends(['startDate' => $startDate, 'endDate' => $endDate]);
                    $grand_total = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                    ->whereDate('created_at', $startDate)
                                                    ->sum('grand_total');
                }
            }else{
                $endDate = Carbon::parse($endDate)->addDay(1);
                if($user->can('order-report')){
                $combined_orders = CombinedOrder::where('status','!=',2)
                                                    ->whereBetween('created_at', [$startDate, $endDate])
                                                    ->paginate(10)
                                                    ->appends(['startDate' => $startDate, 'endDate' => $endDate]);
                $grand_total = CombinedOrder::where('status','!=',2)
                                                    ->whereBetween('created_at', [$startDate, $endDate])
                                                    ->sum('grand_total');
                }else{
                    $combined_orders = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                    ->whereBetween('created_at', [$startDate, $endDate])
                                                    ->paginate(10)
                                                    ->appends(['startDate' => $startDate, 'endDate' => $endDate]);

                    $grand_total = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                    ->whereBetween('created_at', [$startDate, $endDate])
                                                    ->sum('grand_total');
                }
            }
            
            $data = [
                'combined_orders' => $combined_orders,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'grand_total' => $grand_total,
                'lastName' => end($ex)
            ];
            
            if($combined_orders->count() >= 1){
                notify()->success('Showing search result from '. dateFormatter($startDate). ' to ' .dateFormatter($endDate));
                return view('admin.orders.order-list', $data);
            }else{
                notify()->error('Search result not found!');
                return back();
            }

        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }
    

    public function searchRefundedOrder(Request $request){
        try{
            $user = auth()->user();
            $ex = explode(" ", $user->name);

            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if($startDate == $endDate){
                if($user->can('order-report')){
                $combined_orders = CombinedOrder::where('status','=',2)
                                                    ->whereDate('updated_at', $startDate)
                                                    ->paginate(10)
                                                    ->appends(['startDate' => $startDate, 'endDate' => $endDate]);
                    $grand_total = CombinedOrder::where('status','=',2)
                                                    ->whereDate('updated_at', $startDate)
                                                    ->sum('grand_total');
                }else{
                $combined_orders = CombinedOrder::where('user_id', $user->id)->where('status','=',2)
                                                    ->whereDate('updated_at', $startDate)
                                                    ->paginate(10)
                                                    ->appends(['startDate' => $startDate, 'endDate' => $endDate]);
                    $grand_total = CombinedOrder::where('user_id', $user->id)->where('status','=',2)
                                                    ->whereDate('updated_at', $startDate)
                                                    ->sum('grand_total');
                }
            }else{
                $endDate = Carbon::parse($endDate)->addDay(1);
                if($user->can('order-report')){
                $combined_orders = CombinedOrder::where('status','=',2)
                                                    ->whereBetween('updated_at', [$startDate, $endDate])
                                                    ->paginate(10)
                                                    ->appends(['startDate' => $startDate, 'endDate' => $endDate]);
                $grand_total = CombinedOrder::where('status','=',2)
                                                    ->whereBetween('updated_at', [$startDate, $endDate])
                                                    ->sum('grand_total');
                }else{
                    $combined_orders = CombinedOrder::where('user_id', $user->id)->where('status','=',2)
                                                    ->whereBetween('updated_at', [$startDate, $endDate])
                                                    ->paginate(10)
                                                    ->appends(['startDate' => $startDate, 'endDate' => $endDate]);

                    $grand_total = CombinedOrder::where('user_id', $user->id)->where('status','=',2)
                                                    ->whereBetween('updated_at', [$startDate, $endDate])
                                                    ->sum('grand_total');
                }
            }
            
            $data = [
                'combined_orders' => $combined_orders,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'grand_total' => $grand_total,
                'lastName' => end($ex)
            ];
            
            if($combined_orders->count() >= 1){
                notify()->success('Showing search result from '. dateFormatter($startDate). ' to ' .dateFormatter($endDate));
                return view('admin.orders.refunded-orders', $data);
            }else{
                notify()->error('Search result not found!');
                return back();
            }
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }

    public function salesReport(){
        try{
            $startDate = date("Y-m-d");
            $endDate = date("Y-m-d");
            $user = auth()->user();
            $ex = explode(" ", $user->name);

            $products = Product::all();
            $grand_total = Order::whereDate('created_at', $startDate)->sum('sub_total');

            $data = [
                    'products' => $products,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'grand_total' => $grand_total,
                    'lastName' => end($ex)
                ];

                return view('admin.orders.sales', $data);
        }catch(Exception $e){
                notify()->warning($e->getMessage());
                return back();
        }
    }


    public function searchSales(Request $request){
        try {
            // Step 1: Validate inputs (optional, but recommended)
            $request->validate([
                'startDate' => 'required|date',
                'endDate' => 'required|date',
            ]);

            // Step 2: Get the input dates
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            // Step 3: Calculate the grand_total based on date range
            if ($startDate == $endDate) {
                // If the start and end dates are the same, search for that specific day
                $grand_total = Order::whereDate('created_at', $startDate)->sum('sub_total');
            } else {
                // Else search between the start and end dates
                $grand_total = Order::whereBetween('created_at', [$startDate, $endDate])->sum('sub_total');
            }

            // Step 4: Get authenticated user details and last name
            $user = auth()->user();
            $ex = explode(" ", $user->name);
            $lastName = end($ex);

            // Step 5: Get products with pagination (optional: apply filters if needed)
            $products = Product::all();

            // Step 6: Prepare data for view
            $data = [
                'products' => $products,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'grand_total' => $grand_total,
                'lastName' => $lastName
            ];

            // Step 7: Send a success notification with formatted dates
            notify()->success('Showing search result from ' . dateFormatter($startDate) . ' to ' . dateFormatter($endDate));

            // Step 8: Return the view with the prepared data
            return view('admin.orders.sales', $data);

        } catch (\Exception $e) {
            // Log the error (optional)
            // Log::error($e->getMessage());

            // Show warning message and return back
            notify()->warning($e->getMessage());
            return back();
        }
    }
}