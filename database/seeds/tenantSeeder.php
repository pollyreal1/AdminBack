<?php

use Illuminate\Database\Seeder;

class tenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       	DB::table('tenants')->insert([
            'company_id' => '43097612581',
    		'owner_id' => '51200365432846799181',
    		'company_name' => 'The Sample Corp',
    		'owner_email' => 'sample@sample.com',
    		'subscription_type' =>'type1',
    		'database' => 'free_db',
    		'tbl' => 'samplecorp43097612581',
    		'link' => 'samplecorp'
    	]);
        DB::table('tenants')->insert([
            'company_id' => '90628453711',
            'owner_id' => '43276809517846123901',
            'company_name' => 'Smithing Corp',
            'owner_email' => 'jsmith@sample.com',
            'subscription_type' =>'type2',
            'database' => 'standard_db',
            'tbl' => 'smithingcorp90628453711',
            'link' => 'smithingcorp'
        ]);

       	$tbl = 'samplecorp43097612581';
       	clientConnect('127.0.0.1','free_db','root');
       	migrateClientTables($tbl);

       	DB::connection('client')->table('samplecorp43097612581_users')->insert([
            'user_id' => '51200365432846799181',
    		'email' => 'sample@sample.com',
    		'password' => 'sample1',
    		'company_id' => '43097612581',
            'type' => 0
    	]);

        $tbl = 'smithingcorp90628453711';
        clientConnect('127.0.0.1','standard_db','root');
        migrateClientTables($tbl);
        DB::connection('client')->table('smithingcorp90628453711_users')->insert([
            'user_id' => '43276809517846123901',
            'email' => 'jsmith@sample.com',
            'password' => 'sample1',
            'company_id' => '90628453711',
            'type' => 0
        ]);
    }
}
