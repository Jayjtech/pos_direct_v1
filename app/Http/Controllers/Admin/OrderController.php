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
                                ->whereDate('created_at', $startDate)
                                ->paginate(10);
                $grand_total = CombinedOrder::where('status','!=',2)
                                ->whereDate('created_at', $startDate)
                                ->sum('grand_total');
            }else{
                $combined_orders = CombinedOrder::where('user_id', $user->id)
                                ->whereDate('created_at', $startDate)
                                ->where('status', '!=', 2)
                                
                                ->paginate(10);
                $grand_total = CombinedOrder::where('user_id', $user->id)
                                ->whereDate('created_at', $startDate)
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
                    notify()->success('Order successfully refunded!');
                }else{
                    notify()->success('Checked orders successfully refunded!');
                }
                $combined_order->save();
            
            return back();
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
                                                    ->paginate(10);
                    $grand_total = CombinedOrder::where('status','!=',2)
                                                    ->whereDate('created_at', $startDate)
                                                    ->sum('grand_total');
                }else{
                $combined_orders = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                    ->whereDate('created_at', $startDate)
                                                    ->paginate(10);
                    $grand_total = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                    ->whereDate('created_at', $startDate)
                                                    ->sum('grand_total');
                }
            }else{
                $endDate = Carbon::parse($endDate)->addDay(1);
                if($user->can('order-report')){
                $combined_orders = CombinedOrder::where('status','!=',2)
                                                    ->whereBetween('created_at', [$startDate, $endDate])
                                                    ->paginate(10);
                $grand_total = CombinedOrder::where('status','!=',2)
                                                    ->whereBetween('created_at', [$startDate, $endDate])
                                                    ->sum('grand_total');
                }else{
                    $combined_orders = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                    ->whereBetween('created_at', [$startDate, $endDate])
                                                    ->paginate(10);

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

    public function salesReport(){
        try{
            $startDate = date("Y-m-d");
            $endDate = date("Y-m-d");
            $user = auth()->user();
            $ex = explode(" ", $user->name);

            $products = Product::paginate(10);
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
        try{
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            if($startDate !== $endDate){
                // Without adding 1day, it doesn't return the accurate list for the selected date
                $endDate = Carbon::parse($request->input('endDate'))->addDays(1);
                $grand_total = Order::whereDate('created_at', $startDate)->sum('sub_total');
            }
            $grand_total = Order::whereBetween('created_at', [$startDate, $endDate])->sum('sub_total');
            $user = auth()->user();
            $ex = explode(" ", $user->name);

           $products = Product::paginate(10);

            $data = [
                    'products' => $products,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'grand_total' => $grand_total,
                    'lastName' => end($ex)
                ];
                notify()->success('Showing search result from '. dateFormatter($startDate). ' to ' .dateFormatter($endDate));
                return view('admin.orders.sales', $data);
        }catch(Exception $e){
                notify()->warning($e->getMessage());
                return back();
        }
    }
}