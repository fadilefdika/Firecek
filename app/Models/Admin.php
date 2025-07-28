<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'fc_admin';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['username', 'password_hash'];
    
    protected $hidden = ['password_hash'];

    // Kalau tidak pakai fillable, pakai guarded
    protected $guarded = [];
}