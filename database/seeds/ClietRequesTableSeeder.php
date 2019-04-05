<?php

use Illuminate\Database\Seeder;

class ClietRequesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Models\Site\ClientRequest::class,10)->create();
    }
}
