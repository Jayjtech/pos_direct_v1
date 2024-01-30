<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function runBarcode(){
        return view('admin.products.test-barcode-reader');
    }
}