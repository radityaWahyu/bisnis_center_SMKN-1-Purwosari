<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Review extends Model
{
    use Uuids, LogsActivity;

    protected $keyType = 'string';
    public $incrementing = false;
    protected static $logAttributes = ['id', 'name', 'message', 'phone'];
    protected static $recordEvents = ['deleted', 'created', 'updated'];
    protected $fillable = ['name', 'message', 'phone', 'parent_id', 'review_type', 'review_id', 'id_reply'];

    public function items()
    {
        return $this->belongsTo('App\Item','review_id','id');
    }

    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }

}
