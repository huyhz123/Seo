<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('debt_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number', 50)->unique();
            $table->enum('debt_type', ['customer', 'supplier']);
            $table->unsignedBigInteger('debt_id');
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'other'])->default('cash');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->index(['debt_type', 'debt_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('debt_payments');
    }
};
