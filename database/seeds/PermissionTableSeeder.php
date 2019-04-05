<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /**
         * permissions for client request page
         * index
         * show
         * update
         * delete
         */
        DB::table('permissions')->insert([
            'route_name' => 'applications.index',
            'page_name' => 'Client Applications',
            'description' => ' view the client Application Page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'applications.show',
            'page_name' => 'Client Requests',
            'description' => ' visit client application details page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'applications.update',
            'page_name' => 'Client Requests',
            'description' => ' edit client application status'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'applications.export',
            'page_name' => 'Client Applications',
            'description' => 'Export all client Application Page'
        ]);

        /**
         * permissions for clients page
         * index
         * create
         * show
         * update
         * shipping fees
         * Export to Excel
         */
        DB::table('permissions')->insert([
            'route_name' => 'clients.index',
            'page_name' => 'Clients',
            'description' => ' view all clients'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'clients.store',
            'page_name' => 'Clients',
            'description' => ' add new client to the system'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'clients.show',
            'page_name' => 'Clients',
            'description' => ' view client data'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'clients.update',
            'page_name' => 'Clients',
            'description' => ' update client basic information'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'clients.shippingfees',
            'page_name' => 'Clients',
            'description' => ' edit client shipping fees'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'clients.exportExcel',
            'page_name' => 'Clients',
            'description' => 'Export All clients into excel'
        ]);

        /**
         * permissions for cities page
         * index
         * store
         * edit
         * update
         */
        DB::table('permissions')->insert([
            'route_name' => 'cities.index',
            'page_name' => 'Cities',
            'description' => ' view all system cities'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'cities.store',
            'page_name' => 'Cities',
            'description' => ' add new city to the system'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'cities.edit',
            'page_name' => 'Cities',
            'description' => ' display and hide cities'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'cities.update',
            'page_name' => 'Cities',
            'description' => ' update system cities'
        ]);

        /**
         * permissions for areas page
         * index
         * store
         * update
         */
        DB::table('permissions')->insert([
            'route_name' => 'areas.index',
            'page_name' => 'Areas',
            'description' => ' show all areas'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'areas.store',
            'page_name' => 'Areas',
            'description' => ' add new areas to the system'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'areas.update',
            'page_name' => 'Areas',
            'description' => ' update areas data'
        ]);

        /**
         * permissions for offices page
         * index
         * store
         * update
         */
        DB::table('permissions')->insert([
            'route_name' => 'offices.index',
            'page_name' => 'Offices',
            'description' => ' visit offices page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'offices.store',
            'page_name' => 'Offices',
            'description' => ' add new office to the system'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'offices.update',
            'page_name' => 'Offices',
            'description' => ' update office data'
        ]);


        /**
         * permissions for departments page
         * index
         * store
         * update
         */
        DB::table('permissions')->insert([
            'route_name' => 'departments.index',
            'page_name' => 'Departments',
            'description' => ' visit departments page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'departments.store',
            'page_name' => 'Departments',
            'description' => ' add new departments to the system'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'departments.update',
            'page_name' => 'Departments',
            'description' => ' update departments data'
        ]);

        /**
         * permissions for Employees page
         * index
         * store
         * show
         * update
         * Export Excel
         * permissions
         */
        DB::table('permissions')->insert([
            'route_name' => 'employees.index',
            'page_name' => 'Employees',
            'description' => ' visit employee page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'employees.store',
            'page_name' => 'Employees',
            'description' => ' add new employees'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'employees.show',
            'page_name' => 'Employees',
            'description' => ' view employee profile'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'employees.update',
            'page_name' => 'Employees',
            'description' => ' update employee data'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'employees.permissions',
            'page_name' => 'Employees',
            'description' => ' assign permissions to other employees'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'employees.exportExcel',
            'page_name' => 'Employees',
            'description' => 'Export All Employees into excel'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'employees.exportDeliveryExcel',
            'page_name' => 'Employees',
            'description' => 'Export All Delivery Agent Orders'
        ]);


        /**
         * permissions for support page
         * index
         * store
         * show
         * update
         * edit
         * destroy
         */
        DB::table('permissions')->insert([
            'route_name' => 'supports.index',
            'page_name' => 'Support',
            'description' => ' visit support page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'supports.store',
            'page_name' => 'Support',
            'description' => ' add new ticket'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'supports.show',
            'page_name' => 'Support',
            'description' => ' show the chat with the clients'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'supports.update',
            'page_name' => 'Support',
            'description' => ' send messages to the clients'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'supports.export',
            'page_name' => 'Support',
            'description' => ' Export All Clients tickets'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'supports.edit',
            'page_name' => 'Support',
            'description' => 'Close the Ticket'
        ]);

        /**
         * permissions for pickup requests page
         * index
         * store
         * update
         * destroy
         */
        DB::table('permissions')->insert([
            'route_name' => 'pickup_requests.index',
            'page_name' => 'Pickup Request',
            'description' => ' visit pickup requests page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'pickup_requests.store',
            'page_name' => 'Pickup Request',
            'description' => ' add new pickup request'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'pickup_requests.update',
            'page_name' => 'Pickup Request',
            'description' => ' assign pickup request to pickup agent'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'pickup_requests.exportExcel',
            'page_name' => 'Pickup Request',
            'description' => 'Export Pickup Requests into excel'
        ]);

        /**
         * permission for collections page
         * index
         * update
         * destroy
         * export to excel
         */
        DB::table('permissions')->insert([
            'route_name' => 'collections.index',
            'page_name' => 'Collection',
            'description' => ' visit collection page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'collections.edit',
            'page_name' => 'Collection',
            'description' => ' Collect money form delivery agents'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'collections.export',
            'page_name' => 'Collection',
            'description' => 'Export Collections into excel'
        ]);

        /**
         * permissions for finance page
         * index
         * export to excel
         */
        DB::table('permissions')->insert([
            'route_name' => 'finances.index',
            'page_name' => 'Finance',
            'description' => ' visit finance page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'finances.edit',
            'page_name' => 'Finances',
            'description' => 'Change The status of the finance to be Paid'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'finances.exportExcel',
            'page_name' => 'Finances',
            'description' => 'Export Finance into excel'
        ]);

        /**
         * permissions for wallet page
         * index
         * store
         */
        DB::table('permissions')->insert([
            'route_name' => 'wallets.index',
            'page_name' => 'Wallet',
            'description' => ' visit wallet page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'wallets.store',
            'page_name' => 'Wallet',
            'description' => ' add new wallet record'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'wallets.export',
            'page_name' => 'Wallet',
            'description' => ' Export Wallet Record'
        ]);
        /**
         * permissions for shipments page
         * index
         * show
         * update
         * delete
         * print policy
         * print status
         * exportExcel
         * printAll
         * printPolicy
         */
        DB::table('permissions')->insert([
            'route_name' => 'shipments.index',
            'page_name' => 'Shipments',
            'description' => ' visit Shipments page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'shipments.show',
            'page_name' => 'Shipments',
            'description' => ' view Shipments details page'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'shipments.update',
            'page_name' => 'Shipments',
            'description' => ' update Shipments details'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'shipments.destroy',
            'page_name' => 'Shipments',
            'description' => ' delete Shipments'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'shipments.printPolicy',
            'page_name' => 'Shipments',
            'description' => ' print Shipment Policy'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'shipments.exportExcel',
            'page_name' => 'Shipments',
            'description' => ' export all shipments into excel'
        ]);
        DB::table('permissions')->insert([
            'route_name' => 'shipments.printTable',
            'page_name' => 'Shipments',
            'description' => 'Print Orders Policy'
        ]);

        /*
         * permissions for updating orders status
         */
        DB::table('permissions')->insert([
            'route_name' => 'scanner.index',
            'page_name' => 'Scanner',
            'description' => 'Scan and update orders status'
        ]);


    }
}
