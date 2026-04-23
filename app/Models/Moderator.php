<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Moderator extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function obavijesti()
    {
        return $this->hasMany(Obavijest::class);
    }

    public function termini()
    {
        return $this->hasMany(TerminTreninga::class);
    }
}
