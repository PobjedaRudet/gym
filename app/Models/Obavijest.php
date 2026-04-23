<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obavijest extends Model
{
    use HasFactory;

    protected $table = 'obavijesti';

    protected $fillable = [
        'moderator_id',
        'naslov',
        'sadrzaj',
        'slika',
        'tip',
    ];

    public function moderator()
    {
        return $this->belongsTo(Moderator::class);
    }
}
