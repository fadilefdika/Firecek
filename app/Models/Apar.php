<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apar extends Model
{
    protected $table = 'fc_apar';

    protected $fillable = [
        'brand',
        'media_id',
        'type',
        'capacity',
        'expired_date',
        'location_id',
        'location_detail',
    ];

    public $timestamps = true; // karena kamu punya created_at dan updated_at
}