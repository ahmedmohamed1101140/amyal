<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRequestStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_request_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status_from',['New','Open','Accepted','Rejected']);
            $table->enum('status_to',['Open','Accepted','Rejected']);
            $table->text('action');
            $table->integer('agent_id')->unsigned();
            $table->integer('client_request_id')->unsigned();
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
        Schema::dropIfExists('client_request_statuses');
    }
}
