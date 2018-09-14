<?php

use Illuminate\Database\Seeder;

class bundeeRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        clientConnect('127.0.0.1','free_db','root');
        DB::connection('client')->table('samplecorp43097612581_time_tracking')->insert([
            'timetrack_id' => randomNumber(3),
    		'name' => 'Web Kiosk'
    	]);
    	DB::connection('client')->table('samplecorp43097612581_time_tracking')->insert([
            'timetrack_id' => randomNumber(3),
    		'name' => 'DTR'
    	]);
    	DB::connection('client')->table('samplecorp43097612581_time_tracking')->insert([
            'timetrack_id' => randomNumber(3),
    		'name' => 'Web Login'
    	]);
    	DB::connection('client')->table('samplecorp43097612581_time_tracking')->insert([
            'timetrack_id' => randomNumber(3),
    		'name' => 'Android App'
    	]);

    	DB::connection('client')->table('samplecorp43097612581_roles')->insert([
            'role_id' => randomNumber(3),
    		'name' => 'Employee'
    	]);
    	DB::connection('client')->table('samplecorp43097612581_roles')->insert([
            'role_id' => randomNumber(3),
    		'name' => 'HR Admin'
    	]);
    	DB::connection('client')->table('samplecorp43097612581_roles')->insert([
            'role_id' => randomNumber(3),
    		'name' => 'Admin'
    	]);
    	DB::connection('client')->table('samplecorp43097612581_roles')->insert([
            'role_id' => randomNumber(3),
    		'name' => 'Time Keeper'
    	]);


    	clientConnect('127.0.0.1','standard_db','root');
    	DB::connection('client')->table('smithingcorp90628453711_time_tracking')->insert([
            'timetrack_id' => randomNumber(3),
    		'name' => 'Web Kiosk'
    	]);
    	DB::connection('client')->table('smithingcorp90628453711_time_tracking')->insert([
            'timetrack_id' => randomNumber(3),
    		'name' => 'DTR'
    	]);
    	DB::connection('client')->table('smithingcorp90628453711_time_tracking')->insert([
            'timetrack_id' => randomNumber(3),
    		'name' => 'Web Login'
    	]);
    	DB::connection('client')->table('smithingcorp90628453711_time_tracking')->insert([
            'timetrack_id' => randomNumber(3),
    		'name' => 'Android App'
    	]);

    	DB::connection('client')->table('smithingcorp90628453711_roles')->insert([
            'role_id' => randomNumber(3),
    		'name' => 'Employee'
    	]);
    	DB::connection('client')->table('smithingcorp90628453711_roles')->insert([
            'role_id' => randomNumber(3),
    		'name' => 'HR Admin'
    	]);
    	DB::connection('client')->table('smithingcorp90628453711_roles')->insert([
            'role_id' => randomNumber(3),
    		'name' => 'Admin'
    	]);
    	DB::connection('client')->table('smithingcorp90628453711_roles')->insert([
            'role_id' => randomNumber(3),
    		'name' => 'Time Keeper'
    	]);
    }
}
