<?php

namespace App\Models;


class video extends basemodel
{
    public function course()
    {
        return $this->belongsTo(course::class)->withDefault();
    }
}
