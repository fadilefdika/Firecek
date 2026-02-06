<?php

namespace App\Models;

use App\Models\Media;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Apar extends Model
{
    protected $table = 'fc_apar';
    protected $appends = ['gross_weight']; 

    protected $fillable = [
        'brand',
        'media_id',
        'type',
        'capacity',
        'expired_date',
        'location_id',
        'location_detail',
        'apar_code',
        'tube_weight',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Hanya generate jika belum diisi secara manual
            if (!$model->apar_code) {
                $model->apar_code = self::generateUniqueCode();
            }
        });
    }

    private static function generateUniqueCode()
    {
        // Menggunakan query builder murni untuk performa tercepat
        $lastCode = DB::table('fc_apar')
            ->select('apar_code')
            ->where('apar_code', 'LIKE', 'APAR%')
            ->orderBy('id', 'desc') // Mengurutkan berdasarkan id jauh lebih cepat di SQL Server
            ->first();

        if (!$lastCode) {
            return 'APAR001';
        }

        $lastNumber = (int) substr($lastCode->apar_code, 4);
        $nextNumber = $lastNumber + 1;

        return 'APAR' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function getCapacityAttribute($value)
    {
        if ($value === null) return null;
        $num = (float) $value;
        // Jika bilangan bulat (3.0), tampilkan tanpa desimal
        // Jika ada desimal (3.5), tampilkan sesuai aslinya
        return $num % 1 == 0 ? (int) $num : $num;
    }

    public function getGrossWeightAttribute()
    {
        return (float) ($this->capacity ?? 0) + (float) ($this->tube_weight ?? 0);
    }

}