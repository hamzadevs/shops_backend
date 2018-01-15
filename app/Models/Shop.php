<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';

    public function users()
    {
      return $this->belongsToMany('App\Models\User', 'users_shops', 'shop_id', 'user_id')->withTimestamps();
    }
}
