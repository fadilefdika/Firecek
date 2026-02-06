<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'fc_media';

    protected $fillable = ['media_name']; 
}