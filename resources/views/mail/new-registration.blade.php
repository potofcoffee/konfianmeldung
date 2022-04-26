@component('mail::message')
# Neue Anmeldung

Eine neue Konfi-Anmeldung für die Gruppe **{{ $groupName }}** in **{{ $church->name }}** ist eingegangen:

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

{{ $record['vorname'] }} wurde in die KonfiApp eingetragen und kann sich mit dem Code ````{{ $record['username'] }}````
anmelden.

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

Das angehängte Dokument wurde an o.g. E-Mailadressen verschickt. Es kann außerdem unter
[https://konfianmeldung.pfarrplaner.de/pdf/{{ urlencode($filename) }}](https://konfianmeldung.pfarrplaner.de/pdf/{{ urlencode($filename) }})
abgerufen werden.

@component('mail::panel')
Eine Liste aller vorhandenen Anmeldungen findest du [hier](https://konfianmeldung.pfarrplaner.de/liste/{{ $church->name }})
@endcomponent

@endcomponent
