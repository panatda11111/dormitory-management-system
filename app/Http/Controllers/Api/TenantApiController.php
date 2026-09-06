<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;

class TenantApiController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('room')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tenants,
        ]);
    }
}