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
        Schema::create('manage_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->float('earn_type')->nullable();
            $table->float('sick_type')->nullable();
            $table->float('total_leaves')->nullable();
            $table->string('title')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_manage_leaves');
    }
};
