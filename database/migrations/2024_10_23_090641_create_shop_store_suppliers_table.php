<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_store_suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->decimal('buying_price', 14, 2)->nullable();
            $table->decimal('total_buying', 14, 2)->nullable();
            $table->decimal('amount', 14, 2)->nullable();
            $table->string('status', 20)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->timestamp('added_at')->nullable();
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
        Schema::dropIfExists('shop_store_suppliers');
    }
};
