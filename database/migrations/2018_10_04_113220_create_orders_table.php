<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('tracking_number')->unique()->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->integer('cod')->nullable();
            $table->double('security_number')->nullable();
            $table->string('receiver_name')->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('area_id')->unsigned()->nullable();
            $table->integer('office_id')->unsigned()->nullable();
            $table->text('address')->nullable();
            $table->text('mark_place')->nullable();
            $table->integer('shipping_fees')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('status',['Recorded','Picked Up','Received','Out for delivery','Transfer To','Back to shipper','Returned to shipper','Refused','Reschedule','Delivered','Incorrect Phone','Incorrect Address'])->default('Recorded');
            $table->integer('agent_id')->unsigned()->nullable();
            $table->dateTime('pickup_date')->nullable();
            $table->boolean('editable')->default('1');
            $table->boolean('shipping_fees_updated')->default('0');
            $table->integer('delivery_agent_id')->unsigned()->nullable();
            $table->integer('pickup_agent_id')->unsigned()->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
