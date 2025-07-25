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
            $table->string('data_admission');
            $table->string('data_termination')->nullable();
            $table->jsonb('benefits');
            $table->string('position');
            $table->foreignId('salary_id')->constrained('salaries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['salary_id']);
            $table->dropColumn('salary_id');
        });
    }
};
