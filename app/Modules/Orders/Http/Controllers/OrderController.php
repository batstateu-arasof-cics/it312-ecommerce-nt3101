<?php

namespace App\Modules\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->latest()->paginate(10);

        return view('orders::index', compact('orders'));
    }

    // TODO (Orders team): show(Request $request, Order $order) - order detail page (items, totals, address,
    //                 payment status, tracking from ShippingServiceInterface). Only the owner may see it.
    // TODO (Orders team): cancel(Request $request, Order $order) - customer cancels a pending order.
}
