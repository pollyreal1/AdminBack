<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

  function randomNumber($length = 19) {

      return substr_replace(str_shuffle(str_repeat($x = "1029384756", ceil($length / strlen($x)))), 1, $length);
  }

  function guzzle($url, $param = [], $method){

       try{
         $client = new \GuzzleHttp\Client();
         $res = $client->request($method, $url, $param);
         return [
             'data' => json_decode($res->getBody(), true),
             'http_code' => $res->getStatusCode(),
             'header' => $res->getHeaderLine('content-type'),
         ]; 
     }catch(GuzzleHttp\Exception\ConnectException $e){

        
         Session::flash('custom_error', [
             'data' => 'Connection Lost. Some data may not be appeared. <a href="#" onclick="window.location.reload()">[Refresh]</a> again'
         ]);
        


     }catch (GuzzleHttp\Exception\RequestException $e) {

       Session::flash('custom_error', [
             'data' => 'Connection Lost. Some data may not be appeared. <a href="#" onclick="window.location.reload()">[Refresh]</a> again'
         ]);
         
     }

     return ['data' => 'CONN_ERR'];

  }

    function apiToken(){

      return bin2hex(openssl_random_pseudo_bytes(30));

    }

    function customToken($length = 32) {

      $x = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
      return substr(str_shuffle(str_repeat($x, ceil($length / strlen($x)))), 1, $length);

    }

    // FOR DB CONNECTION
    function clientConnect($hostname = null,$database = null, $username = null, $password = null){

        // Disconnect existing DB connection
        DB::purge('tenant');

        Config::set('database.connections.client.host', $hostname);
        Config::set('database.connections.client.database', $database);
        Config::set('database.connections.client.username', $username);
        Config::set('database.connections.client.password', $password);

        // Rearrange the connection data
        DB::connection('client');

        // Ping the database. This will throw an exception in case the database does not exists.
        Schema::connection('client')->getConnection()->reconnect();

    }

    // FOR TABLE CREATION OF TENANT

    function migrateClientTables($tbl){

        Schema::connection('client')->dropIfExists($tbl.'_users');
        Schema::connection('client')->dropIfExists($tbl.'_profile');
        Schema::connection('client')->dropIfExists($tbl.'_roles');
        Schema::connection('client')->dropIfExists($tbl.'_branch');
        Schema::connection('client')->dropIfExists($tbl.'_timetable');
        Schema::connection('client')->dropIfExists($tbl.'_owner_setup');
        Schema::connection('client')->dropIfExists($tbl.'_time_tracking');
        Schema::connection('client')->dropIfExists($tbl.'_branch_time');
        Schema::connection('client')->dropIfExists($tbl.'_user_roles');
        Schema::connection('client')->dropIfExists($tbl.'_user_branch');
        Schema::connection('client')->dropIfExists($tbl.'_company');

        Schema::connection('client')->create($tbl.'_users', function ($table) {
            $table->increments('id');
            $table->string('user_id')->unique();
            $table->string('email')->unique();            
            $table->tinyInteger('type')->default(1);            
            $table->string('password'); 
            $table->string('company_id'); 
            $table->tinyInteger('isActive')->default(1); 
            $table->string('last_seen')->nullable();                                              
            $table->string('api_token')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('created_by')->default('tams'); 
            $table->string('emp_num')->nullable();             
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_profile', function ($table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('tel_num')->nullable();
            $table->string('cell_num')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->default('Photo.png');
            $table->string('reports_to')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_roles', function ($table) {
            $table->increments('id');
            $table->string('role_id')->unique();
            $table->string('name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_branch', function ($table) {
            $table->increments('id');
            $table->string('branch_id')->unique();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('company_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_timetable', function ($table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('type_tracker')->nullable();            
            $table->string('clocking_date')->nullable();
            $table->string('timein');
            $table->string('timeout')->nullable();
            $table->string('company_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_owner_setup', function ($table) {
            $table->increments('id');
            $table->string('company_id');
            $table->string('setup_process')->default(0);
            $table->tinyInteger('trackown_time');
            $table->tinyInteger('allmodules');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_time_tracking', function ($table) {
            $table->increments('id');
            $table->string('timetrack_id')->unique();
            $table->string('name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_branch_time', function ($table) {
            $table->increments('id');
            $table->string('branch_id');
            $table->string('timetrack_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_user_roles', function ($table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('role_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_user_branch', function ($table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('branch_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::connection('client')->create($tbl.'_company', function ($table) {
            $table->increments('id');
            $table->string('company_id')->unique();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('business_type')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

    }

?>