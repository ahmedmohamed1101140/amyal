<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id')->unsigned()->nullable();
            $table->string('time')->nullable();
            $table->string('date')->nullable();
            $table->string('client_name')->nullable();
            $table->string('person_name')->nullable();
            $table->string('person_number')->nullable();
            $table->text('address')->nullable();
            $table->enum('result',['Quote','Order','Request','Canceled']);
            $table->text('reason')->nullable();

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
        Schema::dropIfExists('meetings');
    }
}
