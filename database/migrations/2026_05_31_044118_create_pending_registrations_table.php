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
        Schema::create('pending_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('hoten', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255); // hashed
            $table->string('diachi')->nullable();
            $table->string('sdt', 20)->nullable();
            $table->string('token', 64)->unique();
            $table->timestamp('created_at')->useCurrent();
            // Token hết hạn sau 24h — kiểm tra trong code
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_registrations');
    }
};
