<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasApiTokens, HasProfilePhoto, TwoFactorAuthenticatable;
    use \OwenIt\Auditing\Auditable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'names',
        'lastnames',
        'email',
        'password',
        'address',
    ];

    public function lotteries(): BelongsToMany
    {
        return $this->belongsToMany(Lottery::class, 'lottery_user') // Especificando la tabla intermedia si es necesario
                    ->withPivot('number');  // Accede a la columna 'number' de la tabla intermedia
        
    }

    public function createdLotteries(){
        return $this->hasMany(Lottery::class, 'created_user');
    }
}
