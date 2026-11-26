<?php

namespace App\Modules\Dashboard\Services;

use App\Contracts\ReportServiceInterface;
use App\Modules\Orders\Models\Order;

class ReportService implements ReportServiceInterface
{
    public function salesSummary(?string $from = null, ?string $to = null): array
    {
        $orders = Order::where('status', '!=', Order::CANCELLED)
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to));

        // TODO (Dashboard team): orders_by_status, top_products (by quantity sold), average_order_value

        return [
            'total_sales' => (float) (clone $orders)->sum('total'),
            'order_count' => (clone $orders)->count(),
        ];
    }
}
