<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('ssn')->unique()->nullable();
            $table->text('address')->nullable();
            $table->date('age')->nullable();
            $table->date('join_date')->nullable();
            $table->string('shift_from')->nullable();
            $table->string('shift_to')->nullable();
            $table->text('image')->nullable();
            $table->integer('office_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->string('position')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->enum('type',['Employee','Pickup Agent','Sales Person','Delivery Agent'])->default('Employee');
            $table->integer('city_id')->unsigned()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
