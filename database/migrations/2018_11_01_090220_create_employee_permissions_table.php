<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_permissions');
    }
}
