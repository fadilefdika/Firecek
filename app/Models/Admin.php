<?php 

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'fc_admin';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['username', 'password_hash'];

    // Laravel secara default butuh atribut `password`, jadi kita bisa override accessor
    protected $hidden = ['password_hash'];

    // Tambahkan accessor agar Laravel bisa menemukan password default
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
