<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Item extends Model
{
    use Uuids, LogsActivity;

    protected $keyType = 'string';
    public $incrementing = false;
    protected static $logAttributes = ['id', 'title', 'description', 'image', 'category', 'departement', 'user', 'is_best'];
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    
    public function departements()
    {
        return $this->belongsTo('App\Departement','departement','id');
    }

    public function categories()
    {
        return $this->belongsTo('App\Category','category','id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','user','id');
    }

    public function reviews()
    {
        return $this->morphMany('App\Review', 'review')->whereNull('parent_id');
    }

    public function viewers()
    {
        return $this->morphMany('App\PageCounter', 'view');
    }
}
