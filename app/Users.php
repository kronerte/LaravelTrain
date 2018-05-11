<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
  protected $table = 'users';
  public $timestamps = false;
  protected $fillable = ['pseudo', 'mail', 'password','confirmation'];
}
