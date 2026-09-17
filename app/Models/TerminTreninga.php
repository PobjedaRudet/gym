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

    /**
     * Pronalazi sljedeći nadolazeći termin treninga (najbliži u budućnosti) na
     * osnovu ponavljajućih dana (`dani`, ISO 1=Pon..7=Ned) i vremena početka.
     * Koristi se za "Sljedeći trening" widget na naslovnoj stranici.
     *
     * @return array{termin: TerminTreninga, kada: \Carbon\Carbon, danNaziv: string}|null
     */
    public static function sljedeciTermin(): ?array
    {
        $daniNazivi = [1 => 'Ponedjeljak', 2 => 'Utorak', 3 => 'Srijeda', 4 => 'Četvrtak', 5 => 'Petak', 6 => 'Subota', 7 => 'Nedjelja'];
        $mjeseciNazivi = [1 => 'januar', 2 => 'februar', 3 => 'mart', 4 => 'april', 5 => 'maj', 6 => 'juni', 7 => 'juli', 8 => 'august', 9 => 'septembar', 10 => 'oktobar', 11 => 'novembar', 12 => 'decembar'];

        $sada = \Carbon\Carbon::now();
        $todayIso = (int) $sada->dayOfWeekIso;
        $najbolji = null;

        foreach (static::all() as $termin) {
            if (empty($termin->dani) || !$termin->vrijeme_od) {
                continue;
            }

            // 'datum_od' je vec Carbon instanca zahvaljujuci $casts['datum_od'] = 'date'
            $pocetak = $termin->datum_od ? $termin->datum_od->copy()->startOfDay() : null;

            foreach ($termin->dani as $dan) {
                $dan = (int) $dan;
                if ($dan < 1 || $dan > 7) {
                    continue;
                }

                $diff = ($dan - $todayIso + 7) % 7;
                $kandidatDatum = $sada->copy()->startOfDay()->addDays($diff);
                $kandidat = \Carbon\Carbon::parse($kandidatDatum->format('Y-m-d') . ' ' . $termin->vrijeme_od);

                if ($kandidat->lt($sada)) {
                    $kandidat->addDays(7);
                }

                if ($pocetak) {
                    while ($kandidat->lt($pocetak)) {
                        $kandidat->addDays(7);
                    }
                }

                if (!$najbolji || $kandidat->lt($najbolji['kada'])) {
                    $najbolji = [
                        'termin' => $termin,
                        'kada' => $kandidat,
                        'danNaziv' => $daniNazivi[$dan] ?? '',
                        'datumNaziv' => $kandidat->day . '. ' . ($mjeseciNazivi[(int) $kandidat->month] ?? ''),
                    ];
                }
            }
        }

        return $najbolji;
    }

    /**
     * Sedmični raspored termina, grupisan po danu (ISO 1=Pon..7=Ned), sortiran
     * po vremenu unutar dana. Vraća samo dane koji imaju bar jedan termin.
     * Koristi se za panel "Sljedeći termini" na naslovnoj stranici.
     *
     * @return array<int, array{danNaziv: string, stavke: \Illuminate\Support\Collection}>
     */
    public static function sedmicniRaspored(): array
    {
        $daniNazivi = [1 => 'Ponedjeljak', 2 => 'Utorak', 3 => 'Srijeda', 4 => 'Četvrtak', 5 => 'Petak', 6 => 'Subota', 7 => 'Nedjelja'];

        $poDanima = [];

        foreach (static::orderBy('vrijeme_od')->get() as $termin) {
            foreach ((array) $termin->dani as $dan) {
                $dan = (int) $dan;
                if ($dan < 1 || $dan > 7) {
                    continue;
                }

                $poDanima[$dan][] = $termin;
            }
        }

        ksort($poDanima);

        $raspored = [];
        foreach ($poDanima as $dan => $termini) {
            $raspored[$dan] = [
                'danNaziv' => $daniNazivi[$dan] ?? '',
                'stavke' => collect($termini)->sortBy('vrijeme_od')->values(),
            ];
        }

        return $raspored;
    }
}
