<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            $table->string('billing_month');

            $table->decimal('rent', 10, 2)->default(0);
            $table->decimal('water', 10, 2)->default(0);
            $table->decimal('electricity', 10, 2)->default(0);
            $table->decimal('other_charge', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->date('due_date');

            $table->enum('status', [
                'ค้างชำระ',
                'ชำระแล้ว',
                'เกินกำหนด'
            ])->default('ค้างชำระ');

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};