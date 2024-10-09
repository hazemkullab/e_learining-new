<?php

namespace App\Models;



class category extends basemodel
{
    public function parent()
    {
        return $this->belongsTo(category::class,'parent_id')->withDefault();
    }

    public function courses()
    {
        return $this->hasMany(course::class);
    }
}
