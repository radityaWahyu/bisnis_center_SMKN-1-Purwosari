<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class PageCounter extends Model
{
    use Uuids;
    
    protected $guard=[];
    protected $table = "page_counter";
    public $incrementing = false;
    
    public function items()
    {
        return $this->morphedByMany('App\Item', 'view');
    }

    public function posts()
    {
        return $this->morphedByMany('App\Post', 'view');
    }

}
