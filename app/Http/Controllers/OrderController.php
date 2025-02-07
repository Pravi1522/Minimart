<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function getOrders()
    {
        $orders = Order::where('user_id',Auth::id())->get();
        return view('orders.view', compact('orders'));
    }
}
