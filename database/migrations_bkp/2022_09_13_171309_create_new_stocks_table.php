<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->integer('available_quantity')->nullable();
            $table->integer('added_quantity')->nullable();
            $table->integer('new_quantity')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedInteger('received_by')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('new_stocks');
    }
}
