<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            // อ้างอิงใบแจ้งค่าใช้จ่าย
            $table->foreignId('bill_id')
                ->constrained('bills')
                ->cascadeOnDelete();

            // จำนวนเงินที่ชำระ
            $table->decimal('amount', 10, 2);

            // วันที่ชำระเงิน
            $table->date('payment_date');

            // วิธีชำระเงิน
            $table->enum('payment_method', [
                'เงินสด',
                'โอนเงิน',
                'อื่นๆ'
            ]);

            // หมายเหตุ
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};