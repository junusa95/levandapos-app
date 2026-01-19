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
            $table->string('transfer_no')->nullable();
            $table->integer('transfer_val')->nullable();
            $table->string('from')->nullable();
            $table->string('destination')->nullable();
            $table->unsignedInteger('from_id')->nullable();
            $table->unsignedInteger('destination_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->unsignedInteger('sender_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedInteger('shipper_id')->nullable();
            $table->unsignedInteger('receiver_id')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->unsignedInteger('approver_id')->nullable();
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
        Schema::dropIfExists('transfers');
    }
}
