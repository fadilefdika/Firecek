<?php

namespace App\Models;

use App\Models\Media;
use App\Models\Location;
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

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function aparInspections()
    {
        return $this->hasMany(AparInspection::class);
    }

}