<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //





    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
