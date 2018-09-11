<?php

use Illuminate\Database\Seeder;

class subsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('lib_subs')->insert([
            'subscription_type' => 'type1',
    		'name' => 'Free',
    		'file_size' => '100',
    		'num_users' => '10',
    		'months_subs' =>'1'
    	]);

    	DB::table('lib_subs')->insert([
            'subscription_type' => 'type2',
            'name' => 'Standard',
            'file_size' => '500',
            'num_users' => '50',
            'months_subs' =>'3'
        ]);

    	DB::table('lib_subs')->insert([
            'subscription_type' => 'type3',
            'name' => 'Premium',
            'file_size' => '1000',
            'num_users' => '100',
            'months_subs' =>'6'
        ]);
    }
}
