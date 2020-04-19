<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Gallery extends Model
{
    use Uuids, LogsActivity;

    protected $table = 'galleries';
    protected $keyType = 'string';
    public $incrementing = false;
    protected static $logAttributes = ['id', 'caption', 'image'];
    protected static $recordEvents = ['deleted', 'created', 'updated'];
    protected $fillable = ['caption','image','item'];

    public function items()
    {
        return $this->belongsTo('App\Item','item','id');
    }
}
