<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Support\Str;

class LineLinkController extends Controller
{
    /**
     * สร้างรหัสสำหรับเชื่อมบัญชี LINE ของผู้เช่า
     */
    public function generate(Tenant $tenant)
    {
        // สร้างรหัสที่ไม่ซ้ำกับผู้เช่าคนอื่น
        do {
            $code = 'DORM-' . strtoupper(Str::random(6));
        } while (
            Tenant::where('line_link_code', $code)->exists()
        );

        // รหัสมีอายุ 15 นาที
        $tenant->update([
            'line_link_code' => $code,
            'line_link_code_expires_at' => now()->addMinutes(15),
        ]);

        return back()->with('line_link_code', [
            'tenant_name' => $tenant->name,
            'code' => $code,
            'expires_at' => $tenant->line_link_code_expires_at
                ->format('d/m/Y H:i'),
        ]);
    }
}