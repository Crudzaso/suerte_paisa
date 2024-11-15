<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Lottery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'banner_url',
        'logo_url',
        'date_play',
        'result',
        'prize',
        'price'
    ];

    // Indica a Laravel que 'date_play' debe ser tratado como una fecha
    protected $dates = [
        'date_play', // Asegúrate de que este campo sea tratado como una fecha
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Accesor para convertir 'date_play' a una instancia de Carbon
    public function getDatePlayAttribute($value)
    {
        return Carbon::parse($value); // Convierte el valor a Carbon
    }

    // Mutador para asegurarse de que 'date_play' se guarda correctamente
    public function setDatePlayAttribute($value)
    {
        $this->attributes['date_play'] = Carbon::parse($value)->toDateString(); // Asegura que sea solo fecha sin hora
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'lottery_user')
                    ->withPivot('number')
                    ->withTimestamps();
    }
}
