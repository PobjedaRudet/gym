<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->naslov,
            'body' => $this->sadrzaj,
            'type' => $this->tip,
            'image_url' => $this->slika ? asset('images/obavijesti/' . $this->slika) : null,
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
