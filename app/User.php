<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\UserInfo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->token = str_random(30);
        });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function confirmEmail()
    {
        $this->verifed = true;
        $this->token = null;
        $this->save();
    }

    public function userInfo()
    {
        return $this->hasOne('App\UserInfo');
    }

    public function skill()
    {
        return $this->belongsToMany('App\Skills', 'user_skills');
    }

    /**
     * Подписка в mailchimp
     *
     * @param string $listId Идентификатор листа на который нужно подписать
     * @param string $url Ссылка для обращения по API
     */

    public function subscribeInMailchimp($listId, $url)
    {
        $link = $url.$listId.'/members/';
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:'. env('MAILCHIMP_API'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        $json = json_encode([
            'email_address' => $this->email,
            'status' => 'subscribed',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }
}
