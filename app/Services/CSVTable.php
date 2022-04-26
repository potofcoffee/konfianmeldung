<?php

namespace App\Services;

use App\Models\Church;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CSVTable
{
    /** @var Church */
    protected $church;
    protected $fileName;

    public function __construct(Church $church) {
        $this->church = $church;
        $this->fileName = Carbon::now()->year . '-'.$church->name . '.csv';
        if (!file_exists(storage_path('app/'.$this->fileName))) {
            $this->writeLine([
                'Gruppe',
                'Vorname',
                'Name',
                'Weitere Vornamen',
                'Straße',
                'PLZ',
                'Ort',
                'Handynummer',
                'Geburtsdatum',
                'Geburtsort',
                'Schule',
                'Klasse',
                'Taufdatum',
                'Paten',
                'Taufspruch',
                'KonfiApp: Benutzername',
                'Elternteil 1: Vorname',
                'Elternteil 1: Nachname',
                'Elternteil 1: Telefonnummer',
                'Elternteil 1: E-Mailadresse',
                'Elternteil 1: Benutzername',
                'Elternteil 2: Vorname',
                'Elternteil 2: Nachname',
                'Elternteil 2: Telefonnummer',
                'Elternteil 2: E-Mailadresse',
                'Elternteil 2: Benutzername',
            ]);
        }
    }

    public function storeRecord($record, $parents) {
        $groupName = '';
        foreach ($this->church->groups as $group) {
            if ($group->group_id == $record['groups']) $groupName = $group->name;
        }

        $this->writeLine([
            $groupName,
            $record['vorname'],
            $record['nachname'],
            $record['details']['personal.middlename'],
            $record['details']['address.street'],
            $record['details']['address.plz'],
            $record['details']['address.city'],
            $record['details']['personal.tel'],
            $record['details']['personal.birthdate'],
            $record['details']['personal.birthplace'],
            $record['details']['personal.school'],
            $record['details']['personal.school.class'],
            $record['details']['taufe.date'],
            $record['details']['taufe.paten'],
            $record['details']['taufe.spruch'],
            $record['details']['taufe.spruch'],
            $parents[0]['vorname'] ?? '',
            $parents[0]['nachname'] ?? '',
            $parents[0]['phone'] ?? '',
            $parents[0]['mail'] ?? '',
            $parents[0]['username'] ?? '',
            $parents[1]['vorname'] ?? '',
            $parents[1]['nachname'] ?? '',
            $parents[1]['phone'] ?? '',
            $parents[1]['mail'] ?? '',
            $parents[1]['username'] ?? '',
        ]);
    }

    protected function writeLine($line) {
        $fp = fopen(storage_path('app/'.$this->fileName), 'a');
        fputs($fp, utf8_decode('"'.join('";"', $line).'"'."\r\n"));
        fclose($fp);
    }

}
