<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_debts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->decimal('debt_amount', 14, 2)->nullable();
            $table->string('status')->nullable();
            $table->decimal('stock_value', 14, 2)->nullable();
            $table->decimal('amount_paid', 14, 2)->nullable();
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('user_id')->nullable();
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
        Schema::dropIfExists('customer_debts');
    }
}
