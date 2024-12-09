<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function users()
    {
        return $this->belongsToMany(User::class, 'lottery_user')
                    ->withPivot('number')
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_user');
    }
}
