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
        Schema::create('bookkeeping_income_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bookkeeping_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->decimal('amount', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookkeeping_income_items');
    }
};
