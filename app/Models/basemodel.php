<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class basemodel extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];



    public function getTransNameAttribute()
    {

        $name=$this->name;

        $name_current = json_decode($name,true);
        return $name_current ? $name_current[app()->currentLocale()] : '';
    }


    public function getEnNameAttribute()
    {

        $name=$this->name;
        $name_current = json_decode($name,true);
        return $name_current ? $name_current['en'] : '' ;

    }

    public function getArNameAttribute()
    {

        $name=$this->name;
        $name_current = json_decode($name,true);
        return $name_current ? $name_current['ar'] : '' ;

    }


//excerpt

public function getTransExcerptAttribute()
{

    $name=$this->excerpt;

    $name_current = json_decode($name,true);
    return $name_current ? $name_current[app()->currentLocale()] : '';
}


public function getEnExcerptAttribute()
{

    $name=$this->excerpt;
    $name_current = json_decode($name,true);
    return $name_current ? $name_current['en'] : '' ;

}

public function getArExcerptAttribute()
{

    $name=$this->excerpt;
    $name_current = json_decode($name,true);
    return $name_current ? $name_current['ar'] : '' ;

}



//content

public function getTransContentAttribute()
{

    $name=$this->content;

    $name_current = json_decode($name,true);
    return $name_current ? $name_current[app()->currentLocale()] : '';
}


public function getEnContentAttribute()
{

    $name=$this->content;
    $name_current = json_decode($name,true);
    return $name_current ? $name_current['en'] : '' ;

}

public function getArContentAttribute()
{

    $name=$this->content;
    $name_current = json_decode($name,true);
    return $name_current ? $name_current['ar'] : '' ;

}

}
