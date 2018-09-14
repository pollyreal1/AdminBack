<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenants extends Model
{
    //
    protected $connection = "mysql";
    protected $table = "tenants";
}
