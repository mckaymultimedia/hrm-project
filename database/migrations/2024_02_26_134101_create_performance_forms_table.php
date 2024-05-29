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
        Schema::create('performance_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('quality_of_work')->nullable();
            $table->string('quantity_of_work')->nullable();
            $table->string('ability_to_be_trained')->nullable();
            $table->string('attendance')->nullable();
            $table->string('attitude_toward_job')->nullable();
            $table->string('appearance')->nullable();
            $table->string('punctuality')->nullable();
            $table->string('relations_with_other')->nullable();
            $table->string('overall_evaluation')->nullable();
            $table->text('comment')->nullable();
            $table->text('suggestions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_forms');
    }
};
