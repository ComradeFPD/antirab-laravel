<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    protected $table = 'skills';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsToMany('App\User', 'user_skills');
    }
}
