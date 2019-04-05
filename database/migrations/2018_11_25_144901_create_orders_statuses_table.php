<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->enum('status_from',['Recorded','Picked Up','Received','Out for delivery','Transfer To','Back to shipper','Returned to shipper','Refused','Reschedule','Delivered','Incorrect Phone','Incorrect Address']);
            $table->enum('status_to',['Recorded','Picked Up','Received','Out for delivery','Transfer To','Back to shipper','Returned to shipper','Refused','Reschedule','Delivered','Incorrect Phone','Incorrect Address']);
            $table->unsignedInteger('agent_id');
            $table->string('agent_additional_info')->nullable();
            $table->string('client_additional_info')->nullable();
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
        Schema::dropIfExists('orders_statuses');
    }
}
