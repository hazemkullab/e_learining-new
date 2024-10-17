<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;



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

    public function payment()
    {
        return $this->hasMany(payment::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

}
