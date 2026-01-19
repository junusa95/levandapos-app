<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transfer_no', 20)->nullable();
            $table->integer('transfer_val')->nullable();
            $table->string('from', 20)->nullable();
            $table->string('destination', 20)->nullable();
            $table->unsignedInteger('from_id')->nullable();
            $table->unsignedInteger('destination_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->unsignedInteger('sender_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedInteger('shipper_id')->nullable();
            $table->unsignedInteger('receiver_id')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->unsignedInteger('approver_id')->nullable();
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
        Schema::dropIfExists('transfers');
    }
}
