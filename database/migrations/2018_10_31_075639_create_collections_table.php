<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->integer('office_id')->unsigned();
            $table->double('cod')->default(0);
            $table->enum('status',['Collected','Collect'])->default('Collect');
            $table->unsignedInteger('status_agent')->nullable();
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
        Schema::dropIfExists('collections');
    }
}
