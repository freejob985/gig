<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    protected $table = 'works';
    protected $fillable = ['title','lang','categories_id','start_date','end_date','clients','description','image'];

    public function getCategoriesIdAttribute($value){
        return unserialize($value);
    }
}
