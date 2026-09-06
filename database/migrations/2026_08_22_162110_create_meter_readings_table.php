<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meter_readings', function (Blueprint $table) {

            $table->id();

            // ห้องพัก
            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            // ผู้เช่า
            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('tenants')
                ->nullOnDelete();

            // เดือนที่บันทึกมิเตอร์
            $table->string('billing_month');

            // มิเตอร์น้ำ
            $table->decimal('water_previous', 10, 2)->default(0);
            $table->decimal('water_current', 10, 2)->default(0);
            $table->decimal('water_unit', 10, 2)->default(0);
            $table->decimal('water_rate', 10, 2)->default(0);
            $table->decimal('water_charge', 10, 2)->default(0);

            // มิเตอร์ไฟ
            $table->decimal('electricity_previous', 10, 2)->default(0);
            $table->decimal('electricity_current', 10, 2)->default(0);
            $table->decimal('electricity_unit', 10, 2)->default(0);
            $table->decimal('electricity_rate', 10, 2)->default(0);
            $table->decimal('electricity_charge', 10, 2)->default(0);

            // รวมค่าน้ำ + ค่าไฟ
            $table->decimal('total_charge', 10, 2)->default(0);

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meter_readings');
    }
};