<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('id_card', 13)->unique();
            $table->string('phone');
            $table->string('email')->nullable();

            $table->foreignId('room_id')
                ->constrained('rooms')
                ->onDelete('cascade');

            $table->date('move_in_date');

            $table->decimal('deposit', 10, 2)
                ->default(0);

            $table->enum('status', ['ใช้งาน', 'ย้ายออก'])
                ->default('ใช้งาน');

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
