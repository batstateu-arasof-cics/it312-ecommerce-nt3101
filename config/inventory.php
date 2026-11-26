<?php

// Inventory team - Inventory & Stock
return [
    // A product with stock at or below this number is "low stock".
    'low_stock_threshold' => (int) env('LOW_STOCK_THRESHOLD', 5),
];
