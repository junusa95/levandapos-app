<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 120)->nullable();
            $table->string('image')->nullable();
            $table->decimal('buying_price', 14, 2)->nullable();
            $table->decimal('wholesale_price', 14, 2)->nullable();
            $table->decimal('retail_price', 14, 2)->nullable();
            $table->unsignedInteger('measurement_id')->nullable();
            $table->unsignedInteger('product_category_id')->nullable();
            $table->decimal('min_stock_level', 10, 2)->nullable();
            $table->string('status', 20)->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('expire_date')->nullable();
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
        Schema::dropIfExists('products');
    }
}
