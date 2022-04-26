<!DOCTYPE html>
<html lang="de">
<head></head>
<body>
<h1>Herzlich willkommen bei Konfi, {{ $record['vorname'] }}!</h1>
<p>Wir freuen uns, dass du dabei bist! Deine Anmeldung haben wir registriert.</p>
<p>Als nächstes bitten wir dich, die KonfiApp herunterzuladen. Diese findest du im App Store bzw. im Playstore
    unter dem Titel "KonfiApp".
</p>
<div>
    <ul>
        <li>
            App Store (iPhone): <a href="https://apps.apple.com/us/app/konfiapp/id1435105031">https://apps.apple.com/us/app/konfiapp/id1435105031</a>
        </li>
        <li>
            Play Store (Android): <a href="https://play.google.com/store/apps/details?id=de.philippdormann.konfiapp">https://play.google.com/store/apps/details?id=de.philippdormann.konfiapp</a>
        </li>
    </ul>
</div>
<h2>Als Konfi in der KonfiApp anmelden</h2>
<p>So geht es weiter:</p>
<table>
    <tr><td>Öffne die KonfiApp:</td><td>
        <img height="150" src="https://handbuch.konfiapp.de/konfi/account-erstellen/IMG_1270.png"/>
    </td></tr>
    <tr><td>Wähle “Konfi” aus</td><td></td></tr>
    <tr><td>Klicke auf “Noch keinen Account? Jetzt registrieren!"</td><td></td></tr>
    <tr><td>Du siehst nun folgendes PopUp. <br />
        Gebe deinen Registrierungs-Code <code>{{ $record['username'] }}</code> ein und klicke auf “Ok” </td><td>
        <img height="150" src="https://handbuch.konfiapp.de/konfi/account-erstellen/IMG_1278%20(2).png"/>
    </td></tr>
    <tr><td>Nun siehst du die Registrierung. Gib hier bitte deine persönliche E-Mailadresse und dein gewünschtes Passwort
        an:
        </td><td>
        <img height="150" src="https://handbuch.konfiapp.de/konfi/account-erstellen/IMG_1279%20(2).png"/>
    </td></tr>
    <tr><td>Klicke anschließend auf “Account erstellen”.</td><td></td></tr>
    <tr><td>Fertig! Du bist nun in der KonfiApp angemeldet.</td><td>
        <img height="150" src="https://handbuch.konfiapp.de/konfi/account-erstellen/IMG_1281%20(2).png"/>
    </td></tr>
</table>
<hr/>
<h2>Eltern anmelden</h2>
<p>Auch für Eltern gibt es einen Zugang zur KonfiApp. Dort finden sich z.B. alle unsere Elternbriefe.</p>
<p>Auch hier braucht man für den erstmaligen Zugang einen Registrierungscode. Dieser lautet:</p>
<ul>
    @foreach($parents as $parent)
    <li>Für {{ $parent['vorname'] }} {{ $parent['nachname'] }}: <code>{{ $parent['username'] }}</code></li>
    @endforeach
</ul>
<p>So geht die Einrichtung:</p>
<table>
    <tr><td>Laden Sie die KonfiApp herunter (siehe oben).</td><td></td></tr>
    <tr><td>Öffnen Sie die App und klicken Sie auf den Button “Elternteil” </td><td><img height="150" src="https://handbuch.konfiapp.de/eltern/registrierung-code/Screenshot_20210429-180853.png" /></td></tr>
    <tr><td>Klicken Sie auf “Jetzt registrieren”</td><td><img height="150" src="https://handbuch.konfiapp.de/eltern/registrierung-code/Screenshot_20210429-180859.png" /></td></tr>
    <tr><td>Geben Sie nun Ihren Registrierungs-Code an (siehe oben):</td><td><img height="150" src="https://handbuch.konfiapp.de/eltern/registrierung-code/Screenshot_20210429-181148.png" /></td></tr>
    <tr><td>Geben Sie nun Ihre persönliche E-Mail Adresse und das gewünschte Passwort an.</td><td></td></tr>
    <tr><td>Klicken Sie auf “Account erstellen” </td><td><img height="150" src="https://handbuch.konfiapp.de/eltern/registrierung-code/Screenshot_20210429-181224.png" /></td></tr>
    <tr><td>Fertig! Sie werden direkt im Elternportal angemeldet.</td><td></td></tr>
</table>
<p>Wenn Sie Ihren Zugang eingerichtet haben, können Sie diesen auch im Browser unter <a href="https://elternportal.konfiapp.de">https://elternportal.konfiapp.de</a> nutzen.</p>
</body>
</html>
