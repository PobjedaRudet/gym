<?php

namespace App\Http\Resources\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ocekuje termin ucitan sa withCount('prijave'). Lista termina na koje je
 * clan prijavljen se prosljedjuje kroz $request->attributes ('signed_up_ids').
 */
class TrainingResource extends JsonResource
{
    private const DANI = [1 => 'Ponedjeljak', 2 => 'Utorak', 3 => 'Srijeda', 4 => 'Četvrtak', 5 => 'Petak', 6 => 'Subota', 7 => 'Nedjelja'];

    public function toArray($request)
    {
        $prijavljen = in_array((int) $this->id, (array) $request->attributes->get('signed_up_ids', []), true);
        $broj = (int) ($this->prijave_count ?? 0);
        $dani = array_values(array_filter(array_map('intval', (array) $this->dani), function ($d) {
            return $d >= 1 && $d <= 7;
        }));

        return [
            'id' => $this->id,
            'name' => $this->naziv,
            'description' => $this->opis,
            'start_date' => optional($this->datum_od)->toDateString(),
            'is_active' => !$this->datum_od || $this->datum_od->lte(Carbon::today()),
            'days' => $dani,
            'day_names' => array_map(function ($d) {
                return self::DANI[$d];
            }, $dani),
            'time_from' => substr((string) $this->vrijeme_od, 0, 5),
            'time_to' => substr((string) $this->vrijeme_do, 0, 5),
            'capacity' => (int) $this->max_mjesta,
            'signed_up_count' => $broj,
            'free_places' => max((int) $this->max_mjesta - $broj, 0),
            'is_signed_up' => $prijavljen,
        ];
    }
}
