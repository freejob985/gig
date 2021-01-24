<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    protected $fillable = ['title','lang','icon','image','description','categories_id','excerpt'];

    public function category(){
        return $this->belongsTo('App\ServiceCategory','categories_id');
    }
}
