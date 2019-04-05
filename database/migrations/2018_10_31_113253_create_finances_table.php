<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('agent_id')->unsigned()->nullable();
            $table->double('cod');
            $table->double('shipping_fees');
            $table->double('remains');
            $table->enum('status',['Paid','Unpaid']);
            $table->enum('order_status',['Delivered','Returned to shipper']);
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
        Schema::dropIfExists('finances');
    }
}
