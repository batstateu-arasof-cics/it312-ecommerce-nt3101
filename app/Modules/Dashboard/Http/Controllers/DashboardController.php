<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Contracts\InventoryServiceInterface;
use App\Contracts\ReportServiceInterface;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(ReportServiceInterface $reports, InventoryServiceInterface $inventory)
    {
        $summary = $reports->salesSummary();
        $lowStock = $inventory->lowStock(); // empty until Inventory team implements it

        return view('dashboard::index', compact('summary', 'lowStock'));
    }

    // TODO (Dashboard team): report(Request $request) - sales report for a date range
    // TODO (Dashboard team): export(Request $request) - same report as a CSV download
}
