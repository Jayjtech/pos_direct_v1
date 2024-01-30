<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\CombinedOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;


class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orderPdf($startDate, $endDate){
        try{
            $user = auth()->user();
            $ex = explode(" ", $user->name);
            if($startDate == $endDate){
                if($user->can('order-report')){
                    $combined_orders = CombinedOrder::where('status','!=',2)
                                                        ->whereDate('created_at', $startDate)
                                                        ->get();
                        $grand_total = CombinedOrder::where('status','!=',2)
                                                        ->whereDate('created_at', $startDate)
                                                        ->sum('grand_total');
                }else{
                    $combined_orders = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                        ->whereDate('created_at', $startDate)
                                                        ->get();
                        $grand_total = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                        ->whereDate('created_at', $startDate)
                                                        ->sum('grand_total');
                }
            }else{
                if($user->can('order-report')){
                    $combined_orders = CombinedOrder::where('status','!=',2)
                                                        ->whereBetween('created_at', [$startDate, $endDate])
                                                        ->get();
                    $grand_total = CombinedOrder::where('status','!=',2)
                                                        ->whereBetween('created_at', [$startDate, $endDate])
                                                        ->sum('grand_total');
                }else{
                    $combined_orders = CombinedOrder::where('user_id', $user->id)->where('status','!=',2)
                                                    ->whereBetween('created_at', [$startDate, $endDate])
                                                    ->get();

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
            ];

            $pdf = Pdf::loadView('admin.pdf.order-pdf', $data);
            return $pdf->download(dateFormatter($startDate).' to '.dateFormatter($endDate).' order-report.pdf');
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
       
    }

    public function salesPdf($startDate, $endDate){
        try{
            $grand_total = Order::whereBetween('created_at', [$startDate, $endDate])->where('status', '!=', 2)->sum('sub_total');
            
            if($startDate == $endDate){
                // Without adding 1day, it doesn't return the accurate list for the selected date
                $endDate = Carbon::parse($endDate)->addDays(1);
                $grand_total = Order::whereDate('created_at', $startDate)->where('status', '!=', 2)->sum('sub_total');
            }
            
            $user = auth()->user();
            $ex = explode(" ", $user->name);

           $products = Product::all();

            $data = [
                    'products' => $products,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'grand_total' => $grand_total,
                    'lastName' => end($ex)
                ];
            $pdf = PDF::loadView('admin.pdf.sales-pdf', $data);
            return $pdf->download(dateFormatter($startDate).' to '.dateFormatter($endDate).' sales-report.pdf');
        }catch(Exception $e){
                notify()->error($e->getMessage());
                return back();
        }
    }
}