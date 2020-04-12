<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity; 

class ActivityLog extends Activity
{
    protected $fillable = ['ip_address','browser_name','os_name'];  
    
    public function users()
    {
        return $this->belongsTo('App\User','causer_id','id');
    }

    public function posts()
    {
        return $this->belongsTo('App\Post','subject_id','id');
    }

    public function categories()
    {
        return $this->belongsTo('App\Category','subject_id','id');
    }

    public function departements()
    {
        return $this->belongsTo('App\Departement','subject_id','id');
    }

    public function items()
    {
        return $this->belongsTo('App\Item','subject_id','id');
    }

    public function reviews()
    {
        return $this->belongsTo('App\Review','subject_id','id');
    }

    public function galleris()
    {
        return $this->belongsTo('App\Gallery','subject_id','id');
    }

    public function userSubject()
    {
        return $this->belongsTo('App\User', 'subject_id', 'id');
    }
}
