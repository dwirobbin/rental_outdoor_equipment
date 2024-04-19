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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->foreignId('ordered_by')->constrained('users');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('penalty')->default(0);
            $table->string('image')->nullable();
            $table->enum('status', ['waiting', 'pending', 'cancelled', 'rented', 'passed', 'returned']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
