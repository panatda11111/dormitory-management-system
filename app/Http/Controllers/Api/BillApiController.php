<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;

class BillApiController extends Controller
{
    public function index()
    {
        $bills = Bill::with(['tenant', 'room', 'payments'])
            ->orderByDesc('billing_month')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bills,
        ]);
    }
}