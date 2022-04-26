@component('mail::message')
# Du bist angemeldet!

Hallo {{ $record['vorname'] }},

Wir haben  deine Anmeldung für die Gruppe **{{ $groupName }}** in **{{ $church->name }}** erhalten:

@component('mail::table')
| Feld                                | Wert                                               |
| ----------------------------------- | -------------------------------------------------- |
| Vorname                             | {{ $record['vorname'] }}                           |
| Nachname                            | {{ $record['nachname'] }}                          |
| Straße                              | {{ $record['details']['address.street'] }}     |
| PLZ                                 | {{ $record['details']['address.plz'] }}     |
| Ort                                 | {{ $record['details']['address.city'] }}     |
| Handynummer                         | {{ $record['details']['personal.tel'] }}     |
@if($record['email'])| E-Mailadresse                         | {{ $record['email'] }}     |@endif
| Geburtsdatum                        | {{ \Carbon\Carbon::parse($record['details']['personal.birthdate'])->format('d.m.Y') }}     |
| Geburtsort                          | {{ $record['details']['personal.birthplace'] }}     |
| Schule                              | {{ $record['details']['personal.school'] }}     |
| Klasse                              | {{ $record['details']['personal.school.class'] }}     |
| Taufdatum                           | {{ $record['details']['taufe.date'] ? \Carbon\Carbon::parse($record['details']['taufe.date'])->format('d.m.Y') : '' }}     |
| Paten                           | {{ $record['details']['taufe.paten'] }}     |
| Taufspruch                           | {{ $record['details']['taufe.spruch'] }}     |
@endcomponent

Du wurdest in die KonfiApp eingetragen und kannst dich dort mit dem Code ````{{ $record['username'] }}````
anmelden. Eine Anleitung dazu befindet sich im Anhang. Sie kann außerdem unter
[https://konfianmeldung.pfarrplaner.de/pdf/{{ urlencode($filename) }}](https://konfianmeldung.pfarrplaner.de/pdf/{{ urlencode($filename) }})
abgerufen werden.

@foreach($parents as $parent)

## Elternteil {{$loop->iteration }}

@component('mail::table')
| Feld                                | Wert                                               |
| ----------------------------------- | -------------------------------------------------- |
| Vorname                             | {{ $parent['vorname'] }}                           |
| Nachname                            | {{ $parent['nachname'] }}                          |
| Telefon                             | {{ $parent['phone'] }}     |
| E-Mailadresse                       | {{ $parent['mail'] }}     |
@endcomponent

{{ $parent['vorname'] }} {{ $parent['nachname'] }} wurde in die KonfiApp eingetragen und kann sich mit dem Code ````{{ $parent['username'] }}````
anmelden.
@endforeach

@component('mail::panel')
    Wir freuen uns, dass du dabei bist!
@endcomponent

@endcomponent
