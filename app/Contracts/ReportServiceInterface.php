<?php

namespace App\Contracts;

/**
 * Provided by: Dashboard team
 */
interface ReportServiceInterface
{
    /**
     * Sales figures for a date range (Y-m-d). Null means no limit on that side.
     * Returns at least: total_sales, order_count
     */
    public function salesSummary(?string $from = null, ?string $to = null): array;
}
