<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\LineLinkController;
use App\Http\Controllers\TenantPortalController;
use App\Http\Controllers\TenantBillController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| หน้าแรก
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
|
| ผู้ใช้ที่ Login แล้วทุกบทบาทสามารถเข้าดู Dashboard ได้
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| ระบบผู้เช่า
|--------------------------------------------------------------------------
|
| เฉพาะผู้เช่าเท่านั้น
|
*/

Route::middleware(['auth', 'role:tenant'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ใบแจ้งค่าใช้จ่ายของผู้เช่า
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/tenant/bills',
        [TenantPortalController::class, 'bills']
    )->name('tenant.bills');


    /*
    |--------------------------------------------------------------------------
    | รายละเอียดใบแจ้งค่าใช้จ่ายของผู้เช่า
    |--------------------------------------------------------------------------
    |
    | ผู้เช่าสามารถดูได้เฉพาะบิลของตัวเอง
    |
    */

    Route::get(
        '/tenant/bills/{id}',
        [TenantBillController::class, 'show']
    )->name('tenant.bills.show');


    /*
    |--------------------------------------------------------------------------
    | ประวัติการชำระเงินของผู้เช่า
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/tenant/payments',
        [TenantPortalController::class, 'payments']
    )->name('tenant.payments');

});


/*
|--------------------------------------------------------------------------
| ระบบหลังบ้าน
|--------------------------------------------------------------------------
|
| เฉพาะผู้ดูแลระบบเท่านั้น
|
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ห้องพัก
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'rooms',
        RoomController::class
    );


    /*
    |--------------------------------------------------------------------------
    | ผู้เช่า
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'tenants',
        TenantController::class
    );


    /*
    |--------------------------------------------------------------------------
    | เชื่อมบัญชี LINE ของผู้เช่า
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/tenants/{tenant}/line-link/generate',
        [LineLinkController::class, 'generate']
    )->name('tenants.line-link.generate');


    /*
    |--------------------------------------------------------------------------
    | ใบแจ้งค่าใช้จ่าย
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'bills',
        BillController::class
    );


    /*
    |--------------------------------------------------------------------------
    | มิเตอร์น้ำ / ไฟ
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'meter-readings',
        MeterReadingController::class
    );


    /*
    |--------------------------------------------------------------------------
    | ระบบชำระเงิน
    |--------------------------------------------------------------------------
    */

    // ประวัติการชำระเงินทั้งหมด
    Route::get(
        '/payments',
        [PaymentController::class, 'index']
    )->name('payments.index');


    // รายละเอียดการชำระเงิน
    Route::get(
        '/payments/{id}',
        [PaymentController::class, 'show']
    )->name('payments.show');


    // ลบรายการชำระเงิน
    Route::delete(
        '/payments/{id}',
        [PaymentController::class, 'destroy']
    )->name('payments.destroy');


    /*
    |--------------------------------------------------------------------------
    | ชำระเงินของใบแจ้งค่าใช้จ่าย
    |--------------------------------------------------------------------------
    */

    // แบบฟอร์มชำระเงิน
    Route::get(
        '/bills/{bill}/payment',
        [PaymentController::class, 'create']
    )->name('payments.create');


    // บันทึกการชำระเงิน
    Route::post(
        '/bills/{bill}/payment',
        [PaymentController::class, 'store']
    )->name('payments.store');

});


/*
|--------------------------------------------------------------------------
| โปรไฟล์
|--------------------------------------------------------------------------
|
| ผู้ใช้ที่ Login แล้วทุกบทบาทสามารถแก้ไขโปรไฟล์ของตัวเองได้
|
*/

Route::middleware('auth')->group(function () {

    // หน้าแก้ไขโปรไฟล์
    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    // อัปเดตโปรไฟล์
    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    // ลบบัญชี
    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';