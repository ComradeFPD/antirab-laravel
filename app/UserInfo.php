<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';

    public $timestamps = false;

    protected $fillable = [
      'lastname', 'firstname', 'patronomyc'
    ];

    public function city()
    {
        return $this->hasOne('App\City');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
