<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CombinedOrder;
use Exception;
use Illuminate\Http\Request;

class CashflowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewCashFlow(){
        $startDate = date("Y-m-d");
        $endDate = date("Y-m-d");
        $user = auth()->user();
        $ex = explode(" ", $user->name);
        $discount = 0;
        if($user->can('order-report')){
            $cash_sales = CombinedOrder::whereDate('created_at', $startDate)->where('payment_method',1)->selectRaw('sum(grand_total) as cash_total')->first(); //Cash payment
            $pos_sales = CombinedOrder::whereDate('created_at', $startDate)->where('payment_method',2)->selectRaw('sum(grand_total) as pos_total')->first(); //Card payment
            $bank_sales = CombinedOrder::whereDate('created_at', $startDate)->where('payment_method',3)->selectRaw('sum(grand_total) as bank_total')->first(); //Bank payment

            $list = CombinedOrder::whereDate('created_at', $startDate)->get();
        }else{
            $cash_sales = CombinedOrder::whereDate('created_at', $startDate)->where('user_id', $user->id)->where('payment_method',1)->selectRaw('sum(grand_total) as cash_total')->first(); //Cash payment
            $pos_sales = CombinedOrder::whereDate('created_at', $startDate)->where('user_id', $user->id)->where('payment_method',2)->selectRaw('sum(grand_total) as pos_total')->first(); //Card payment
            $bank_sales = CombinedOrder::whereDate('created_at', $startDate)->where('user_id', $user->id)->where('payment_method',3)->selectRaw('sum(grand_total) as bank_total')->first(); //Bank payment
            $list = CombinedOrder::whereDate('created_at', $startDate)->where('user_id', $user->id)->get();
        }        

        if($list){
            foreach($list as $li){
                foreach($li->orders as $order){
                    $discount = $discount+$order->discount;
                }
            } 
        }
         
        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'lastName' => end($ex),
            "cash_sales" => $cash_sales,
            "pos_sales" => $pos_sales,
            "bank_sales" => $bank_sales,
            "total_discount" => $discount
        ];
        
        return view('admin.cashflow.cashflow', $data);
    }

    public function searchCashflow(Request $request){
       try{
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $user = auth()->user();
            $ex = explode(" ", $user->name);
            $discount = 0;
            
            if($startDate === $endDate){
                if($user->can('order-report')){
                    $cash_sales = CombinedOrder::whereDate('created_at', $startDate)->where('payment_method',1)->selectRaw('sum(grand_total) as cash_total')->first(); //Cash payment
                    $pos_sales = CombinedOrder::whereDate('created_at', $startDate)->where('payment_method',2)->selectRaw('sum(grand_total) as pos_total')->first(); //Card payment
                    $bank_sales = CombinedOrder::whereDate('created_at', $startDate)->where('payment_method',3)->selectRaw('sum(grand_total) as bank_total')->first(); //Bank payment

                    $list = CombinedOrder::whereDate('created_at', $startDate)->get();
                }else{
                    $cash_sales = CombinedOrder::whereDate('created_at', $startDate)->where('user_id', $user->id)->where('payment_method',1)->selectRaw('sum(grand_total) as cash_total')->first(); //Cash payment
                    $pos_sales = CombinedOrder::whereDate('created_at', $startDate)->where('user_id', $user->id)->where('payment_method',2)->selectRaw('sum(grand_total) as pos_total')->first(); //Card payment
                    $bank_sales = CombinedOrder::whereDate('created_at', $startDate)->where('user_id', $user->id)->where('payment_method',3)->selectRaw('sum(grand_total) as bank_total')->first(); //Bank payment
                    $list = CombinedOrder::whereDate('created_at', $startDate)->where('user_id', $user->id)->get();
                }      
            }else{
                if($user->can('order-report')){
                    $cash_sales = CombinedOrder::whereBetween('created_at', [$startDate, $endDate])->where('payment_method',1)->selectRaw('sum(grand_total) as cash_total')->first(); //Cash payment
                    $pos_sales = CombinedOrder::whereBetween('created_at', [$startDate, $endDate])->where('payment_method',2)->selectRaw('sum(grand_total) as pos_total')->first(); //Card payment
                    $bank_sales = CombinedOrder::whereBetween('created_at', [$startDate, $endDate])->where('payment_method',3)->selectRaw('sum(grand_total) as bank_total')->first(); //Bank payment

                    $list = CombinedOrder::whereBetween('created_at', [$startDate, $endDate])->get();
                }else{
                    $cash_sales = CombinedOrder::whereBetween('created_at', [$startDate, $endDate])->where('user_id', $user->id)->where('payment_method',1)->selectRaw('sum(grand_total) as cash_total')->first(); //Cash payment
                    $pos_sales = CombinedOrder::whereBetween('created_at', [$startDate, $endDate])->where('user_id', $user->id)->where('payment_method',2)->selectRaw('sum(grand_total) as pos_total')->first(); //Card payment
                    $bank_sales = CombinedOrder::whereBetween('created_at', [$startDate, $endDate])->where('user_id', $user->id)->where('payment_method',3)->selectRaw('sum(grand_total) as bank_total')->first(); //Bank payment
                    $list = CombinedOrder::whereBetween('created_at', [$startDate, $endDate])->where('user_id', $user->id)->get();
                }      
            }

            if($list){
                foreach($list as $li){
                    foreach($li->orders as $order){
                        $discount = $discount+$order->discount;
                    }
                } 
            }

            $data = [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'lastName' => end($ex),
                "cash_sales" => $cash_sales,
                "pos_sales" => $pos_sales,
                "bank_sales" => $bank_sales,
                "total_discount" => $discount
            ];

            notify()->success('Showing search result from '. dateFormatter($startDate). ' to ' .dateFormatter($endDate));
            return view('admin.cashflow.cashflow', $data);
       }catch(Exception $e){
            notify()->warning($e->getMessage());
            return back();
        }
    }
    
}