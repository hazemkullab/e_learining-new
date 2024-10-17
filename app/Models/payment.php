<?php

namespace App\Models;

class payment extends basemodel
{
    public function course()
    {
        return $this->belongsTo(course::class)->withDefault();
    }
}
