<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->enum('status',['New','Open','Accepted','Rejected'])->default('New');
            $table->text('action')->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('agent_id')->unsigned()->nullable();
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
        Schema::dropIfExists('client_requests');
    }
}
