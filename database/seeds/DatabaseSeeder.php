<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([subsSeeder::class,tenantSeeder::class,bundeeRolesSeeder::class]);
    }
}
