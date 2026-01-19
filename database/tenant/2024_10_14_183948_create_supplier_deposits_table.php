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
        Schema::create('supplier_deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->decimal('amount', 14, 2)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('status', 20)->nullable();
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
        Schema::dropIfExists('supplier_deposits');
    }
};
