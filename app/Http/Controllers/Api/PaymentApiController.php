<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentApiController extends Controller
{
    public function index()
    {
        $payments = Payment::with('bill')
            ->orderByDesc('payment_date')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }
}