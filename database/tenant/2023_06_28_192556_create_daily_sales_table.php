<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date', 20)->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->decimal('total_sales', 14, 2)->nullable();
            $table->decimal('quantities', 11, 2)->nullable();
            $table->decimal('total_expenses', 14, 2)->nullable();
            $table->decimal('profit', 14, 2)->nullable();
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
        Schema::dropIfExists('daily_sales');
    }
}
