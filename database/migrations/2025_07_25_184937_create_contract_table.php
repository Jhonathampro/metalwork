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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('date_admission');
            $table->string('date_termination')->nullable();
            $table->jsonb('benefits');
            $table->string('position');
            $table->decimal('value_salary', 10, 2);
            $table->integer('day_payment');
            $table->decimal('discount_salary', 10, 2);
            $table->decimal('total_salary', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
