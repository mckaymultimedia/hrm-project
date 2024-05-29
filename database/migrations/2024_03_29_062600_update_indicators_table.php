<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the existing indicators table if it exists
        Schema::dropIfExists('indicators');

        // Recreate the indicators table with the new structure
        Schema::create('indicators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch')->default(0);
            $table->string('title')->nullable();
            $table->integer('unsatisfactory')->default(0);
            $table->integer('average')->default(0);
            $table->integer('above_average')->default(0);
            $table->integer('not_applicable')->default(0);
            $table->integer('not_observed')->default(0);
            $table->integer('first_month')->default(0);
            $table->integer('six_month')->default(0);
            $table->integer('year')->default(0);
            $table->integer('department')->default(0);
            $table->integer('designation')->default(0);
            $table->string('rating')->nullable();
            $table->integer('customer_experience')->default(0);
            $table->integer('marketing')->default(0);
            $table->integer('administration')->default(0);
            $table->integer('professionalism')->default(0);
            $table->integer('integrity')->default(0);
            $table->integer('attendance')->default(0);
            $table->integer('created_user')->default(0);
            $table->integer('created_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the indicators table if it exists
        Schema::dropIfExists('indicators');
    }
}
