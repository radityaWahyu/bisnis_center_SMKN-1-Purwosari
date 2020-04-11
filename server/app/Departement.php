<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Departement extends Model
{

    use Uuids, LogsActivity;

    protected $primaryKey = "id";
    protected $keyType = 'string';
    public $incrementing = false;
    protected static $logAttributes = ['id', 'name'];
    protected static $recordEvents = ['deleted', 'created', 'updated'];
    
    public function Items()
    {
        return $this->hasMany('App\Item','departement','id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','id','departement');
    }
}
