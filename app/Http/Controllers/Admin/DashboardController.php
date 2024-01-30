<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        /**return the last name */
        $user = auth()->user();
        $ex = explode(" ", auth()->user()->name);
        // For admin
        $allOrdersToday = CombinedOrder::where('status', 1)->whereDate('created_at', now()->toDateString())->sum('grand_total');
        $allOrdersThisWeek = CombinedOrder::where('status', 1)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('grand_total');
        $allOrdersThisMonth = CombinedOrder::where('status', 1)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('grand_total');
        $allOrdersThisYear = CombinedOrder::where('status', 1)->whereBetween('created_at', [$startOfYear, $endOfYear])->sum('grand_total');

        // For user
        $myOrdersToday = CombinedOrder::where('status', 1)->where('user_id', $user->id)->whereDate('created_at', now()->toDateString())->sum('grand_total');
        $myOrdersThisWeek = CombinedOrder::where('status', 1)->where('user_id', $user->id)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('grand_total');
        $myOrdersThisMonth = CombinedOrder::where('status', 1)->where('user_id', $user->id)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('grand_total');
        $myOrdersThisYear = CombinedOrder::where('status', 1)->where('user_id', $user->id)->whereBetween('created_at', [$startOfYear, $endOfYear])->sum('grand_total');

        $data = [
            'lastName' => end($ex),
            'allOrdersToday' => $allOrdersToday,
            'allOrdersThisWeek' => $allOrdersThisWeek,
            'allOrdersThisMonth' => $allOrdersThisMonth,
            'allOrdersThisYear' => $allOrdersThisYear,
            'myOrdersToday' => $myOrdersToday,
            'myOrdersThisWeek' => $myOrdersThisWeek,
            'myOrdersThisMonth' => $myOrdersThisMonth,
            'myOrdersThisYear' => $myOrdersThisYear,
        ];

        return view('dashboard', $data);
    }
}