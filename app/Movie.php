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
        return $this->belongsToMany(Actor::class)->withPivot('name_in_movie');
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function featuredPhoto() {
        return $this->hasOne(Media::class)->where('type','image');
    }
}
