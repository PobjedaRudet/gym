<?php

namespace App\Http\Resources\Api\V1;

use App\Services\MembershipService;
use App\Services\MemberStatsService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Podaci o clanu za aplikaciju. Namjerno se NE vracaju jmbg, code (RFID),
 * is_admin, adresa ni lozinka.
 */
class MemberResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'photo_url' => $this->image_path ? asset('images/' . $this->image_path) : null,
            'register_date' => $this->register_date,
            'membership' => app(MembershipService::class)->summary($this->resource),
            'goals' => app(MemberStatsService::class)->goals($this->resource),
        ];
    }
}
