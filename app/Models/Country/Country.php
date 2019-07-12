<?php

namespace App\Models\Country;

use Session;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
     protected $table = 'country';
     protected $fillable = ['name','iso','nicename'];
}
