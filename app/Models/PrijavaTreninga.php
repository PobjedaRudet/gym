<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrijavaTreninga extends Model
{
    use HasFactory;

    protected $table = 'prijave_treninga';

    protected $fillable = [
        'termin_id',
        'member_id',
    ];

    public function termin()
    {
        return $this->belongsTo(TerminTreninga::class, 'termin_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
