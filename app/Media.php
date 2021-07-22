<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['type','media_name'];
    protected $table = 'medias';
}
