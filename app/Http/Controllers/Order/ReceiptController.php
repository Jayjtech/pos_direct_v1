<?php

namespace App\Http\Controllers\Order;

use Exception;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class ReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function viewReceipt($id){  
        try{
            $combined_order = CombinedOrder::findOrFail($id);
        
            $order = Order::where('combined_order_id', $id)->where('status','!=', 2)->get(); 
            $buyer_details = json_decode($combined_order->buyer_details); //Using order column on combined_order_tbl
            if($order->count() > 0){
                return view('admin.orders.receipt-file', compact('combined_order','order','buyer_details'));
            }else{
                notify()->error('The selected order is empty!');
                return back();
            }
            
        }catch(Exception $e){
            notify()->warning($e->getMessage());
            return redirect()->route('shop');
        }
    }

    
}