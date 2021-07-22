<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    //



    public function movies()
    {
        return $this->belongsToMany(Movie::class)->withPivot('name_in_movie');
    }

}
