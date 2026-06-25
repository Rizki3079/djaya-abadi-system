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
        Schema::create('bookkeeping_expense_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bookkeeping_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('expense_vendor_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('invoice_number')
                ->nullable();

            $table->date('invoice_date')
                ->nullable();

            $table->enum('payment_status', [
                'lunas',
                'cicilan'
            ])->default('lunas');

            $table->text('description')
                ->nullable();

            $table->decimal('amount', 15, 2);

            $table->string('attachment')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookkeeping_expense_items');
    }
};
