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
        Schema::create('yearly_sales', function (Blueprint $table) {
            $table->id();
            $table->string('from_to', 50)->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->decimal('total_sales', 16, 2)->nullable();
            $table->decimal('quantities', 12, 2)->nullable();
            $table->decimal('total_expenses', 14, 2)->nullable();
            $table->decimal('profit', 14, 2)->nullable();
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
        Schema::dropIfExists('yearly_sales');
    }
};
