<?php

namespace App\Models;

use App\Services\PushNotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obavijest extends Model
{
    use HasFactory;

    protected $table = 'obavijesti';

    protected $fillable = [
        'moderator_id',
        'fb_post_id',
        'naslov',
        'sadrzaj',
        'slika',
        'tip',
        'javno',
    ];

    protected $casts = [
        'javno' => 'boolean',
    ];

    protected static function booted()
    {
        // Svaka nova obavijest (admin, moderator, Facebook sync) odmah ide kao
        // push notifikacija na telefone clanova.
        static::created(function (Obavijest $obavijest) {
            app(PushNotificationService::class)->sendAnnouncement($obavijest);
        });
    }

    public function moderator()
    {
        return $this->belongsTo(Moderator::class);
    }
}
