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
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('line_link_code', 20)
                ->nullable()
                ->unique()
                ->after('line_user_id');

            $table->timestamp('line_link_code_expires_at')
                ->nullable()
                ->after('line_link_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropUnique(['line_link_code']);
            $table->dropColumn([
                'line_link_code',
                'line_link_code_expires_at',
            ]);
        });
    }
};