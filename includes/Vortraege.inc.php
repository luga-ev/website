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
$list_items = array();

$menu->main = 'Angebote';
$menu->sub = 'Vortraege';

// $code enthält den HTML-Code für die Vortragsübersicht
$code = '<table id="vortraege">
		<thead>
		<tr>
		<th>Datum</th><th>Titel</th><th>Referent(en)</th>
		</tr>
		</thead>';

//$fh = fopen($v_liste_file, 'r');
$file_list = scandir('../md/Angebote/Vortraege');
chdir('../md/Angebote/Vortraege');

foreach ($file_list as $md_file)	{

	if(substr($md_file, 0, 1) != '_' and substr($md_file, 0, 1) != '.')	{

		$content = file_get_contents($md_file);
		preg_match('/##(.*)\n/', $content, $match);
		$title = $match[1];
		$titel = trim($title);

		preg_match('/###.*Ref.*\n(.*)\n/', $content, $match);
		$referent = trim($match[1]);
		// Eckige Klammern enttfernen
		$referent = str_replace('[', '', $referent);
		$referent = str_replace(']', '', $referent);
		$referent = preg_replace('/\(.*\)/', '', $referent);

		preg_match('/###.*Datum.*\n(.*)\n/', $content, $match);
		$date = trim($match[1]);
		$datum = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

		$link = str_replace('.md', '', $md_file);
		$list_items[$datum][] = "$titel|$referent|$link";

	}
}

$vortraege = array();
// Listen nach Datum und Titel sortieren
krsort($list_items);
//print_r($list_items);

foreach ($list_items as $key => &$liste)	{
	sort($liste);
	foreach ($liste as $values)	{
		list($a, $b, $c) = explode('|', $values);
		$vortraege[] = array(
				$key,
				$a,
				$b,
				$c,
		);
	}
}


foreach ($vortraege as $listitem)	{

	// neuer Tbody?
	if($counter == 0)	{
		// Alten Tbody schließen
		if($tbody > 0)	{
			$code .= "</tbody>";
			$bis = $n -1;

			$reiter .= "<div class=\"reiter\" id=\"reiter$tbody\" onclick=\"showTab($tbody)\">$von&ndash;$bis</div>\n";
			$qreiter .= "<div class=\"reiter\" id=\"qreiter$tbody\" onclick=\"showTab($tbody)\">$von&ndash;$bis</div>\n";
		}
		$code .= "<tbody id=\"tb$tbody\">\n";
		$tbody++;
		$von = $n;

	}


	$datum = iso_to_date($listitem[0]);

	$code .= "<tr><td class=\"datum\">$datum</td><td class=\"v_titel\"><a href=\"$listitem[3]/\">$listitem[1]</a></td><td class=\"referent\">$listitem[2]</td></tr>\n";

	$n++;
	$counter++;
	if($counter == $max)	$counter = 0;


}

$bis = $n -1 ;
$reiter .= "<div class=\"reiter\" id=\"reiter$tbody\" onclick=\"showTab($tbody)\">$von&ndash;$bis</div>\n";
$qreiter .= "<div class=\"reiter\" id=\"qreiter$tbody\" onclick=\"showTab($tbody)\">$von&ndash;$bis</div>\n";
$code .= "</tbody>\n</table>\n";

$code = "<h2>Vorträge</h2>
<p>Ein wichtiger Bestandteil der LUGA e.V. Aktivitäten ist die Weitergabe von Linux-Kenntnissen
 an Mitglieder und Nichtmitglieder. Aus diesem Grund werden auf den monatlichen Treffen
Vorträge zu verschiedenen Themen aus dem Linux Bereich gehalten. Alle Vorträge werden
zusätzlich an dieser Stelle veröffentlicht.</p>" . $reiter . $code . $qreiter .
'<script type="text/javascript">
		tabInit();
</script>';

