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
            $table->string('name')->nullable();
            $table->text('about')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->string('status')->nullable();
            $table->string('reminder')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('contact_person')->nullable();
            $table->string('folder')->nullable();
            $table->string('logo')->nullable();
	    $table->string('cashier_stock_approval')->nullable();
            $table->string('can_transfer_items')->nullable();
	    $table->string('has_product_categories')->nullable();
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
