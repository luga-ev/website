<?php
/*********************************************************
 * Includefile für die Generierung der Vortragsübersicht *
**********************************************************/

$v_liste_file = '../menu/vortraege.csv';
$max = 30;
$counter = 0;
$tbody = 0;
$reiter = '';
$n = 1;
$von = 0;
$bis = 0;

$menu->main = 'Angebote';
$menu->sub = 'Vortraege';

// $code enthält den HTML-Code für die Vortragsübersicht
$code = '<table id="vortraege">
		<thead>
		<tr>
		<th>Datum</th><th>Titel</th><th>Referent(en)</th>
		</tr>
		</thead>';

$fh = fopen($v_liste_file, 'r');

// Zeile für Zeile einlesen
while ($zeile = fgets($fh))	{

	// neuer Tbody?
	if($counter == 0)	{
		// Alten Tbody schließen
		if($tbody > 0)	{
			$code .= "</tbody>";
			$bis = $n -1;

			$reiter .= "<div class=\"reiter\" id=\"reiter$tbody\" onclick=\"showTab($tbody)\">$von&ndash;$bis</div>\n";
		}
		$code .= "<tbody id=\"tb$tbody\">\n";
		$tbody++;
		$von = $n;

	}

	// Kommentarzeilen # überlesen
	if(substr($zeile, 0, 1) != '#')	{
		list($datum, $titel, $referent, $link)	= explode('|', $zeile);
		$datum = iso_to_date($datum);
		$link = str_replace("\n", '', $link);
		$code .= "<tr><td class=\"datum\">$datum</td><td class=\"v_titel\"><a href=\"$link/\">$titel</a></td><td class=\"referent\">$referent</td></tr>\n";
	}

	$n++;
	$counter++;
	if($counter == $max)	$counter = 0;
}

$bis = $n -1 ;
$reiter .= "<div class=\"reiter\" id=\"reiter$tbody\" onclick=\"showTab($tbody)\">$von&ndash;$bis</div>\n";
$code .= "</tbody>\n</table>\n";
fclose($fh);

$code = "<h2>Vorträge</h2>
<p>Ein wichtiger Bestandteil der LUGA e.V. Aktivitäten ist die Weitergabe von Linux-Kenntnissen
 an Mitglieder und Nichtmitglieder. Aus diesem Grund werden auf den monatlichen Treffen
Vorträge zu verschiedenen Themen aus dem Linux Bereich gehalten. Alle Vorträge werden
zusätzlich an dieser Stelle veröffentlicht.</p>" . $reiter . $code . $reiter .
'<script type="text/javascript">
		tabInit();
</script>';

