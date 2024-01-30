<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function exportProducts(){
        try{
            $products = Product::all();
            return FastExcel::data($products)->download('products.csv', function($product){
               return [
                    'Name' => $product->name,
                    'Price' => $product->price,
                    'Product Code' => $product->product_code,
                ];
            });
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }

    public function importProducts(Request $request){
        try{
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt',
            ]);
            $category_id = $request->category_id;
            $csvFile = $request->file('csv_file');
            $filePath = $csvFile->storeAs('csv_import', 'temp_files.csv');
            $filePath = storage_path("app/csv_import/temp_files.csv");
            $data = FastExcel::import($filePath);

            foreach($data as $row){
                // Convert keys to lowercase and replace spaces with underscores
                $outputArray = array_combine(
                    array_map(function ($key) {
                        return strtolower(str_replace(' ', '_', $key));
                    }, array_keys($row)),
                    $row
                );
               
                $exists = Product::where('name', $outputArray['name'])->first();
                if(!$exists){
                    Product::create([
                        'name' => $outputArray['name'],
                        'price' => $outputArray['price'],
                        'category_id' => $category_id,
                        'product_code' => $outputArray['product_code'],
                    ]);
                }else{
                    $exists->price = $outputArray['price'];
                    $exists->category_id = $category_id;
                    $exists->product_code = $outputArray['product_code'];
                    $exists->save();
                }
            }
            notify()->success('Products successfully uploaded');
            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }

    public function downloadReport($startDate, $endDate){
        try{
            if($startDate == $endDate){
                $orders = Order::where('status', '!=', 2)->whereDate('created_at', $startDate)->get();
            }else{
                $orders = Order::where('status', '!=', 2)->whereBetween('created_at', [$startDate, $endDate])->get();
            }
            
            return FastExcel::data($orders)->download('orders.csv', function($order){
                $buyer_details = json_decode($order->combinedOrder->buyer_details);
                return [
                        'Buyer' => $buyer_details->buyer,
                        'Sold by' => $order->user->name,
                        'Product' => $order->product,
                        'Quantity' => $order->qty,
                        'Sub total' => $order->sub_total,
                        'Discount %' => $order->discount,
                    ];
            });

        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }
}