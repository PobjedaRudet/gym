<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminTreninga extends Model
{
    use HasFactory;

    protected $table = 'termini_treninga';

    protected $fillable = [
        'moderator_id',
        'naziv',
        'opis',
        'datum_od',
        'dani',
        'vrijeme_od',
        'vrijeme_do',
        'max_mjesta',
    ];

    protected $casts = [
        'datum_od' => 'date',
        'dani' => 'array',
    ];

    public function moderator()
    {
        return $this->belongsTo(Moderator::class);
    }

    public function prijave()
    {
        return $this->hasMany(PrijavaTreninga::class, 'termin_id');
    }

    public function prijavljeniClanovi()
    {
        return $this->belongsToMany(Member::class, 'prijave_treninga', 'termin_id', 'member_id')->withTimestamps();
    }
}
