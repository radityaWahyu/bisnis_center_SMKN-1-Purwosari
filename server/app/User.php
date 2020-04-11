<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use Uuids, LogsActivity;

    public $incrementing = false;
    protected $keyType = 'string';
    protected static $logAttributes = ['id', 'name', 'email', 'departement', 'password', 'level', 'phone', 'image'];
    protected static $recordEvents = ['deleted', 'created', 'updated'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level', 'departement', 'image', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departements()
    {
        return $this->hasOne('App\Departement','id', 'departement');
    }

    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }
    public function items()
    {
        return $this->hasMany('App\Item', 'id', 'user');
    }
}
