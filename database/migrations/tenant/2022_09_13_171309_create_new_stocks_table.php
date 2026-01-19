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
            $table->unsignedInteger('supplier_id')->nullable();
            $table->decimal('available_quantity', 10, 2)->nullable();
            $table->decimal('added_quantity', 10, 2)->nullable();
            $table->decimal('new_quantity', 10, 2)->nullable();
            $table->decimal('buying_price', 14, 2)->nullable();
            $table->decimal('total_buying', 14, 2)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedInteger('received_by')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->string('status', 20)->nullable();
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
