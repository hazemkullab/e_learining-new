<?php

namespace App\Models;



class course extends basemodel
{
    public function category()
    {
        return $this->belongsTo(category::class)->withDefault();
    }
    public function videos()
    {
        return $this->hasMany(video::class);
    }
}
