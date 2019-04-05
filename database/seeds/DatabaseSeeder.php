<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CityTableSeeder::class);
        $this->call(AreaTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(OfficeTableSeeder::class);
        $this->call(AgentTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(EmployeeRolesSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(ShippingFeesTableSeeder::class);
//        $this->call(ClietRequesTableSeeder::class);
//        $this->call(OrderTableSeeder::class);

    }
}
