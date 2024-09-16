<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
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


        $sumToday = Order::whereDate('created_at', now()->toDateString())
                                    ->where('status', 1) // Refunded
                                    ->selectRaw('sum(sub_cost_price) as grand_cost_price, sum(sub_selling_price) as grand_selling_price, sum(sub_total) as grand_total')
                                    ->first();

        $sumWeek = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                                ->where('status', 1) // Refunded
                                ->selectRaw('sum(sub_cost_price) as grand_cost_price, sum(sub_selling_price) as grand_selling_price, sum(sub_total) as grand_total')
                                ->first();

        $sumMonth = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                ->where('status', 1) // Refunded
                                ->selectRaw('sum(sub_cost_price) as grand_cost_price, sum(sub_selling_price) as grand_selling_price, sum(sub_total) as grand_total')
                                ->first();

        $sumYear = Order::whereBetween('created_at', [$startOfYear, $endOfYear])
                                ->where('status', 1) // Refunded
                                ->selectRaw('sum(sub_cost_price) as grand_cost_price, sum(sub_selling_price) as grand_selling_price, sum(sub_total) as grand_total')
                                ->first();
        $data = [
            'lastName' => end($ex),
            'allOrdersToday' => $allOrdersToday,
            'sumToday' => $sumToday,
            'allOrdersThisWeek' => $allOrdersThisWeek,
            'sumWeek' => $sumWeek,
            'allOrdersThisMonth' => $allOrdersThisMonth,
            'sumMonth' => $sumMonth,
            'allOrdersThisYear' => $allOrdersThisYear,
            'sumYear' => $sumYear,
            'myOrdersToday' => $myOrdersToday,
            'myOrdersThisWeek' => $myOrdersThisWeek,
            'myOrdersThisMonth' => $myOrdersThisMonth,
            'myOrdersThisYear' => $myOrdersThisYear,
        ];

        return view('dashboard', $data);
    }
}