<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Category extends Model
{
    use Uuids;

    protected $table = 'categories';
    protected $keyType = 'string';
    public $incrementing = false;

    public function items()
    {
        return $this->hasMany('App\Item','category','id');
    }
}
