<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('conversations')) {
            Schema::create('conversations', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('customer_id');
                $table->unsignedInteger('staff_id')->nullable();
                $table->enum('status', ['active', 'closed', 'waiting'])->default('active');
                $table->timestamps();

                $table->foreign('customer_id')->references('id_nd')->on('nguoidung')->onDelete('cascade');
                $table->foreign('staff_id')->references('id_nd')->on('nguoidung')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
