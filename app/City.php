<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';

    public function userInfo()
    {
        return $this->belongsTo('App\UserInfo');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
