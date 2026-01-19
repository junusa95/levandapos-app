<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sale_no')->nullable();
            $table->integer('sale_val')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('buying_price', 14, 2)->nullable();
            $table->decimal('selling_price', 14, 2)->nullable();
            $table->decimal('sub_total', 14, 2)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('edited_at')->nullable();
            $table->unsignedInteger('edited_by')->nullable();
            $table->string('sale_type')->nullable();
            $table->string('is_order')->nullable();
            $table->unsignedInteger('ordered_by')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
