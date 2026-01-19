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
            $table->string('sale_no', 25)->nullable();
            $table->integer('sale_val')->nullable();
            $table->string('custom_no', 20)->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->decimal('buying_price', 14, 2)->nullable();
            $table->decimal('total_buying', 14, 2)->nullable();
            $table->decimal('selling_price', 14, 2)->nullable();
            $table->decimal('sub_total', 14, 2)->nullable();
            $table->decimal('paid_amount', 14, 2)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('edited_at')->nullable();
            $table->unsignedInteger('edited_by')->nullable();
            $table->string('sale_type', 20)->nullable();
            $table->unsignedInteger('payment_option_id')->nullable();
            $table->string('is_order', 10)->nullable();
            $table->unsignedInteger('ordered_by')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
