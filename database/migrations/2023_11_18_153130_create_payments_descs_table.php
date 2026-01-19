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
        Schema::create('payments_descs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('payment_id')->nullable();
            $table->decimal('paid_amount', 14, 2)->nullable();
            $table->unsignedSmallInteger('no_of_months')->nullable();
            $table->string('paid_for', 20)->nullable(); 
            $table->string('paid_item', 20)->nullable();
            $table->timestamp('paid_date')->nullable();
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
        Schema::dropIfExists('payments_descs');
    }
};
