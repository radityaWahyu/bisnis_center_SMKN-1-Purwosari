<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use Uuids, LogsActivity;

    protected $keyType = 'string';
    public $incrementing = false;
    protected static $logAttributes = ['id', 'title', 'user', 'departement', 'is_publish'];
    protected static $recordEvents = ['deleted', 'created', 'updated'];
    protected $fillable = ['title','slug','content','image','user','departement','is_publish'];

    public function departements()
    {
        return $this->belongsTo('App\Departement','departement','id');
    }
    
    public function users()
    {
        return $this->belongsTo('App\User','user','id');
    }

    public function viewers()
    {
        return $this->morphMany('App\PageCounter', 'view');
    }
}
