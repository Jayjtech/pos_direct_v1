<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SharedTraits;
use Exception;

class StockController extends Controller
{
    use SharedTraits;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userStockRequestList(){
        $user = auth()->user();
        $stocks = Stock::where('user_id', $user->id)
                        ->where('status', 0)
                        ->paginate(10);

        $ex = explode(" ", $user->name);
        $data = [
            'lastName' => end($ex),
            'stocks' => $stocks,
        ];
        return view('admin.stocks.user-request-stock-list', $data);
    }
    // Make Request View
    public function stockRequestView(){
        $products = Product::where('status', 1)->get();
        $view = view('admin.stocks.partials.make-request', compact('products'))->render();
        return response()->json([
            'view' => $view,
        ]);
    }
    
    // Add Request View
    public function stockAddProductView(){
        $products = Product::where('status', 1)->get();
        $row_id = Str::random(4);
        $view = view('admin.stocks.partials.add-product', compact('products','row_id'))->render();
        return response()->json([
            'view' => $view,
        ]);
    }

    // Edit Request View
    public function stockEditProductView(Request $request){
        $products = Product::where('status', 1)->get();
        $stock = Stock::where('id', $request->stock_id)->first();
        $view = view('admin.stocks.partials.edit-request', compact('products','stock'))->render();
        
        return response()->json([
            'view' => $view,
        ]);
    }

    // Send Request
    public function sendStockRequest(Request $request){
        try{
            $user = auth()->user();
            
            foreach($request->product_ids as $key => $value){
                $stock = new Stock();
                $product = Product::where('id', $request->product_ids[$key])->first();
                $exists = Stock::where('product', $product->name)
                                ->where('status',0)
                                ->where('user_id',$user->id)->first();
                if(!$exists){
                    $stock->product = $product->name;
                    $stock->product_id = $request->product_ids[$key];
                    $stock->product_code = $product->product_code;
                    $stock->qty_requested = $request->quantities[$key];
                    $stock->barcode = $product->barcode;
                    $stock->user_id = $user->id;
                    $stock->save();
                }
            }

            notify()->success('Request sent successfully!');
            return back();
        }catch(Exception $e){
            if($e->getMessage()){
                notify()->error($e->getMessage());
                return back();
            }
        }
    }

    public function saveStockRequestChanges(Request $request){
        try{
            $user = auth()->user();
            $stock = Stock::findOrFail($request->stock_id);
            if($stock->status == 1){
                notify()->warning("Sorry, You can't edit already approved request!");
                return back();
            }
            $stock->qty_requested = $request->quantity;
            $stock->save();
                notify()->success("Changes successfully saved for ". $stock->products->name);
                return back();
                
        }catch(Exception $e){
            if($e->getMessage()){
                notify()->error($e->getMessage());
                return back();
            }
        }
    }

    public function deleteStock($id){
        try{
            $stock = Stock::findOrFail($id);
            if($stock->status == 1){
                notify()->warning("Sorry, You can't delete already approved request!");
                return back();
            }

            notify()->info($stock->products->name. " successfully removed!");
            $stock->delete();
            return back();

        }catch(Exception $e){
           if($e->getMessage()){
                notify()->error($e->getMessage());
                return back();
            } 
        }
    }

    // Approve
    public function userStockRequestApprovalList(){
        $user = auth()->user();
        $stocks = Stock::where('status', 0)->paginate(10);

        $ex = explode(" ", $user->name);
        $data = [
            'lastName' => end($ex),
            'stocks' => $stocks,
        ];
        return view('admin.stocks.approval-request-list', $data);
    }

    public function approveCheckedStock(Request $request){
        try{
            foreach($request->stocks as $stock_id){
                $stock = Stock::findOrFail($stock_id);
                $product = Product::where('id', $stock->product_id)->first();
                $stock->qty_before_approval = $product->availability;
                $product->availability += $stock->qty_requested;
                $stock->qty_after_approval = ($product->availability);
                $stock->status = 1;
                $product->save();
                $stock->save();
            }
            notify()->success('Checked stock requests successfully approved!');
            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }

    public function approveAllStock(){
        try{
            $stocks = Stock::where('status', 0)->get();

            foreach($stocks as $st){
                $product = Product::where('id', $st->product_id)->first();
                $st->qty_before_approval = $product->availability;
                $product->availability += $st->qty_requested;
                $st->qty_after_approval = ($product->availability);
                $st->status = 1;
                $product->save();
                $st->save();
            }

            notify()->success('All stock requests successfully approved!');
            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }

    public function stockApprovalLogs(){
        $user = auth()->user();
        if($user->can('approve-stock')){
            $stocks = Stock::where('status', 1)
                        ->paginate(10);
        }else{
            $stocks = Stock::where('user_id', $user->id)
                        ->where('status', 1)
                        ->orderBy('id','desc')
                        ->paginate(10);
        }
        
        $ex = explode(" ", $user->name);
        $data = [
            'lastName' => end($ex),
            'stocks' => $stocks,
        ];
        return view('admin.stocks.approval-logs', $data);
    }
}