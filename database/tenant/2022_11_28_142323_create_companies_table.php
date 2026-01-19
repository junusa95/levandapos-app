<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 120)->nullable();
            $table->text('about')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->string('status', 20)->nullable();
            $table->string('status2', 20)->nullable();
            $table->string('reminder', 10)->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('contact_person')->nullable();
            $table->string('folder', 120)->nullable();
            $table->string('logo', 120)->nullable();
            $table->string('tin', 30)->nullable();
            $table->string('vrn', 30)->nullable();
	        $table->string('cashier_stock_approval', 10)->nullable();
            $table->string('can_transfer_items', 10)->nullable();
	        $table->string('has_product_categories', 10)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
