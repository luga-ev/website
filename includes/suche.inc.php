<?php
/**********************************************************
 * Suche nach Dateiinhalten über grep
 * Die Suchlogik folgt im Groben der von Google
 * Mehrere Begriffe werden durch Leerzeichen
 * voneinander getrennt.
 * Durch Voransgtellen eines Minuszeichens - wird der
 * Begriff von der Suche ausgeschlossen.
 **********************************************************/

$searchitem = $_POST['searchitem'];
$first_item = '';

$code = "<h3>LUGA Suche</h3>\n
		<form name=\"findform\" action=\"/start/suche/\" method=\"post\">
		<div class=\"search\">
		<input type=\"text\" name=\"searchitem\" size=\"35\" value=\"$searchitem\">
		<img src=\"/images/edit-find-symbolic.svg\" alt=\"Suchen\" onclick=\"document.findform.submit()\">
		</div>
		</form>\n ";


$list = explode(' ', $_POST['searchitem']);
$grepper = array('../bin/suche ');
$flag = false;

foreach ($list as $item)	{
	// Anführungsstriche ; backticks und Hochkommas entfernen
	$item = str_replace('"', '', $item);
	$item = str_replace("'", '', $item);
	$item = str_replace('`', '', $item);

	if(!empty($item))	{
		// ist das erste zeichen ein miuns?
		if(substr($item, 0, 1) == '-')	{
			$term = substr($item, 1);
			$grepper[] = "grep -iv \"$term\"";
		} else {
			if(!$flag)	{
				// Nur beim ersten Erlement darf recursiv in den Verzeichnissen gesucht werden.
				$grepper[] = "grep -ri \"$item\"";
			} else {
				$grepper[] = "grep -i \"$item\"";
			}
			$flag = true;
			if (empty($first_item)) {
				$first_item = $item;
			}
		}
	}
}

if($flag)	{
	chdir('../md');
	$elements = count($grepper);
	// Bei nur 2 elementen gibt es eine schnellere Suche
	if ($elements == 2) {
		unset($grepper[0]);
		$grepper[1] .= ' *';
	} else {
		$grepper[0] .= $first_item;
	}

	$command = join('|', $grepper);
	//$code .="$command\n";
	$result = `$command`;
	$result = explode("\n", $result);

	// Array mit Dateinamen anlegen, um doppelte Nennungen zu vermeiden
	// und eine Gewichtung zu erzeugen.
	$hits = array();

	foreach ($result as $entry)	{
		if(!empty($entry))	{
			list($file, $text) = explode(':', $entry, 2);
			$file = substr($file, 0, -3);

			if (isset($hits[$file]))	{
				$hits[$file]++;
			} else {
				$hits[$file] = 1;
			}
		}
	}
	unset($hits[0]);

	$count = count($hits);
	if ($count > 0) {
		$code .= "<p>$count Ergebnisse für <b>$searchitem:</b></p>\n";
	} else {
		$code .= "<p>Keine Ergebnisse für <b>	$searchitem</b></p>\n";
	}

	// Menüs einlesen
	$menu_x = get_menu();
	$vortraege = get_vortraege();

	// Anzahl der Hits; über 20 in Parzellen Aufteilen
	$number_hits = count($hits);
	if ($number_hits > 10) {
		$tablist = '<div id="tablist">';
		$flag_section = true;

		$tab_number = floor($number_hits / 10);
		$i = 0;
		while ($i <= $tab_number)	{
			$von = $i * 10  + 1;
			$bis = $i * 10 + 10;
			if ($i == 0) {
				$aktiv = ' reiteraktiv';
			} else {
				$aktiv = '';
			}
			if( $bis > $number_hits) $bis = $number_hits;
			$tablist .= "<div class=\"reiter$aktiv\" onclick=\"showSection($i)\">$von - $bis</div> " ;
			$i++;
		}
		$tablist .= "</div>\n";
		$code .= $tablist;
		$tablist = str_replace('tablist', 'tablist_u', $tablist);
	} else {
		$flag_section = false;
	}
	$n = 0;
	$section = 0;
	foreach ($hits as $key => $value)	{
		if ($flag_section) {
			if ($n == 0) {
				$code .= "\n<div id=\"section_$section\" class=\"section\">\n";
			}
		}
		$md_file = "$key.md";

		if (isset($vortraege[$key]))	{
			// in Vorträgen suchen
			$code .= '<div class="searchresult">'.
			"<a href=\"/$key/\">" .
			$vortraege[$key]['beschreibung'] . "</a><br />\n" .
			'Vortrag von ' . $vortraege[$key]['referent'] . ' am ' .
			iso_to_date($vortraege[$key]['datum']) .
			"</div>\n";
		}
		elseif (file_exists($md_file)) {
			// In menü suchen
			$description = get_description($md_file);
			$link = "/$key";
			$code .= '<div class="searchresult">'.
			'<a href="' . $link . '/">' .
			$menu_x["/$key/"] . "</a><br />$description</div>\n";
		}

		if ($flag_section) {
			$n++;
			if( $n == 10) {
				$code .= "</div>\n";
				$n = 0;
				$section++;
			}
		}
	}

	// letztes abshließendes </div>
	if ($flag_section) {
		if ($n != 0) {
			$code .= "</div>\n" . $tablist;
		}
	}
}



/* Liest die Menüdatei und gibt sie als array zurück
 * wobei der Dateiname der Key ist
 * @return array Menüdatei Key = dateiname; value = Beschreibung
 */
function get_menu()	{
	$menu = array();

	$menu_file = '../menu/menu.csv';
	$fh = fopen ( $menu_file, 'r' ) or die ( 'Failed to open Menu' );

	while ($line = fgetcsv($fh, 0, '|'))	{
		if(substr($line[0], 0, 1) != '#')	{
			$path = explode('/', $line[1]);
			$anz = count($path);

			switch ($anz)	{
				case 3:
					$key = $path[1];
					break;
				case 4:
					$key = $path[2];
					break;
			}

			$menu[$line[1]] = $line[0];
		}
	}
	return $menu;

}

/* liest die Vortragsdatei und gibt sie als Array zurück
 * @return array Vortragsmenue
 *               key = dateiname
 *               [beschreibung]
 *               [datum]
 *				 [referent]
 */
function get_vortraege()	{
	$menu = array();

	$menu_file = '../menu/vortraege.csv';
	$fh = fopen ( $menu_file, 'r' ) or die ( 'Failed to open Menu' );

	while ($line = fgetcsv($fh, 0, '|'))	{
		if(substr($line[0], 0, 1) != '#')	{
			$menu['Angebote/Vortraege/' .$line[3]] = array(
					'beschreibung' => $line[1],
					'datum' => $line[0],
					'referent' => $line[2]

			);
		}
	}

	return $menu;

}

/* Liest die ersten 200 Zeichen einer Datei und gibt sie als Beschreibung aus.
 * @param string Dateiname
 * @return string Beschreibung
 */
function get_description($filename)	{
	$text = file_get_contents($filename);
	$text = str_replace('#', '', $text);
	$text = str_replace('*', '', $text);
	$text =  substr($text, 0, 200) . ' ....';
	$text = html_entity_decode($text);

	return $text;
}