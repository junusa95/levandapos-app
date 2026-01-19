<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClosureSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closure_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('expected_cash', 14, 2)->nullable();
            $table->decimal('submitted_cash', 14, 2)->nullable();
            $table->decimal('difference', 14, 2)->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('closed_by')->nullable();
            $table->unsignedInteger('company_id')->nullable();
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
        Schema::dropIfExists('closure_sales');
    }
}
