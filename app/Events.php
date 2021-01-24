<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events';
    protected $fillable = ['title','status','lang','date','image','location','content','category_id'];

    public function category(){
        return $this->hasOne('App\EventsCategory','id','category_id');
    }
}
