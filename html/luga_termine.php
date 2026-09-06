<?php
/**
 * LUGA-Treffen: jeden 1. Mittwoch im Monat.
 * Fällt dieser auf einen Feiertag in Augsburg, verschiebt sich das
 * Treffen auf den darauffolgenden Mittwoch.
 *
 * Ausgabe: die nächsten drei Treffen, ab dem aktuellen Datum,
 * als text/plain in Tabellenzeilen-Form.
 */

header('Content-Type: text/plain; charset=utf-8');

date_default_timezone_set('Europe/Berlin');

// ---------------------------------------------------------------------
// Feiertage in Augsburg für ein gegebenes Jahr ermitteln
// (gesetzliche bayerische Feiertage + Augsburger Friedensfest,
//  Mariä Himmelfahrt gilt in Augsburg als überwiegend katholischer Ort)
// ---------------------------------------------------------------------
function feiertageAugsburg(int $jahr): array
{
    $ostersonntag = new DateTime('@' . easter_date($jahr));
    $ostersonntag->setTime(0, 0, 0);

    $tage = [];

    $add = function (DateTime $d) use (&$tage) {
        $tage[$d->format('Y-m-d')] = true;
    };

    $add(new DateTime("$jahr-01-01")); // Neujahr
    $add(new DateTime("$jahr-01-06")); // Heilige Drei Könige

    $karfreitag = (clone $ostersonntag)->modify('-2 days');
    $add($karfreitag);

    $ostermontag = (clone $ostersonntag)->modify('+1 day');
    $add($ostermontag);

    $add(new DateTime("$jahr-05-01")); // Tag der Arbeit

    $christiHimmelfahrt = (clone $ostersonntag)->modify('+39 days');
    $add($christiHimmelfahrt);

    $pfingstmontag = (clone $ostersonntag)->modify('+50 days');
    $add($pfingstmontag);

    $fronleichnam = (clone $ostersonntag)->modify('+60 days');
    $add($fronleichnam);

    $add(new DateTime("$jahr-08-08")); // Augsburger Friedensfest (nur Augsburg)
    $add(new DateTime("$jahr-08-15")); // Mariä Himmelfahrt (in Augsburg gültig)

    $add(new DateTime("$jahr-10-03")); // Tag der Deutschen Einheit
    $add(new DateTime("$jahr-11-01")); // Allerheiligen

    $add(new DateTime("$jahr-12-25")); // 1. Weihnachtsfeiertag
    $add(new DateTime("$jahr-12-26")); // 2. Weihnachtsfeiertag

    return $tage;
}

function istFeiertagAugsburg(DateTime $datum): bool
{
    static $cache = [];
    $jahr = (int) $datum->format('Y');

    if (!isset($cache[$jahr])) {
        $cache[$jahr] = feiertageAugsburg($jahr);
    }

    return isset($cache[$jahr][$datum->format('Y-m-d')]);
}

// ---------------------------------------------------------------------
// Ersten Mittwoch eines Monats ermitteln
// ---------------------------------------------------------------------
function ersterMittwoch(int $jahr, int $monat): DateTime
{
    $datum = new DateTime(sprintf('%04d-%02d-01', $jahr, $monat));
    $wochentag = (int) $datum->format('N'); // 1 = Montag ... 7 = Sonntag
    $mittwoch = 3;

    $diff = ($mittwoch - $wochentag + 7) % 7;
    $datum->modify("+{$diff} days");

    return $datum;
}

// ---------------------------------------------------------------------
// LUGA-Treffen für einen Monat berechnen (inkl. Verschiebung)
// ---------------------------------------------------------------------
function lugaTreffen(int $jahr, int $monat): DateTime
{
    $datum = ersterMittwoch($jahr, $monat);

    while (istFeiertagAugsburg($datum)) {
        $datum->modify('+7 days');
    }

    return $datum;
}

// ---------------------------------------------------------------------
// Nächste drei Treffen ab heute ermitteln
// ---------------------------------------------------------------------
$heute = new DateTime('today');

$monatsnamen = [
    1 => 'Januar', 2 => 'Februar', 3 => 'März', 4 => 'April',
    5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Dezember',
];

$jahr = (int) $heute->format('Y');
$monat = (int) $heute->format('n');

$treffen = [];

while (count($treffen) < 3) {
    $termin = lugaTreffen($jahr, $monat);

    if ($termin >= $heute) {
        $treffen[] = $termin;
    }

    $monat++;
    if ($monat > 12) {
        $monat = 1;
        $jahr++;
    }
}

// ---------------------------------------------------------------------
// Ausgabe erzeugen
// ---------------------------------------------------------------------
foreach ($treffen as $termin) {
    $tag = (int) $termin->format('j');
    $monatNr = (int) $termin->format('n');
    $jahrTermin = $termin->format('Y');
    $monatName = $monatsnamen[$monatNr];

    printf(
        "|%d. %s %s|[%streffen %s](/Treffen/Termine/%02d_%s/)|\n",
        $tag,
        $monatName,
        $jahrTermin,
        $monatName,
        $jahrTermin,
        $monatNr,
        $jahrTermin
    );
}