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
        Schema::create('bookkeepings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('outlet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->date('bookkeeping_date');

            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('service', 15, 2)->default(0);

            $table->decimal('owner_note_amount', 15, 2)->default(0);

            $table->decimal('total_income', 15, 2)->default(0);
            $table->decimal('total_non_cash', 15, 2)->default(0);
            $table->decimal('total_expense', 15, 2)->default(0);

            $table->decimal('cash_on_hand', 15, 2)->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['outlet_id', 'bookkeeping_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookkeepings');
    }
};
