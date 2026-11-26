@extends('layouts.app')

@section('title', 'My orders')

@section('content')
<h1 class="text-2xl font-bold mb-6">My orders</h1>

@if ($orders->isEmpty())
    <p>No orders yet.</p>
@else
    <table class="w-full bg-white rounded shadow text-sm">
        <thead class="text-left border-b">
            <tr><th class="p-3">Order</th><th class="p-3">Date</th><th class="p-3">Status</th><th class="p-3">Payment</th><th class="p-3 text-right">Total</th></tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr class="border-b">
                    {{-- TODO (Orders team): link to orders.show --}}
                    <td class="p-3 font-medium">{{ $order->number() }}</td>
                    <td class="p-3">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="p-3 capitalize">{{ $order->status }}</td>
                    <td class="p-3 uppercase">{{ $order->payment_method }}</td>
                    <td class="p-3 text-right">₱{{ number_format($order->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection
