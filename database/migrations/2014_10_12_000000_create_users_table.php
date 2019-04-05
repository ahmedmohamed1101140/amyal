<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('address')->nullable();
            $table->text('pickup_address')->nullable();
            $table->string('cp_name')->nullable();
            $table->string('cp_phone')->unique()->nullable();
            $table->string('account_number')->unique();
            $table->string('status')->default('Active');
            $table->text('action')->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('office_id')->unsigned()->nullable();
            $table->integer('agent_id')->unsigned()->nullable();
            $table->dateTime('last_login')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('first_login')->default(0);
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
        Schema::dropIfExists('users');
    }
}
