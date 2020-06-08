<?php
/****************************************************************************************
 * Linux User Group Augsburg (LUGA) e.V.
 *
 * @version 1.0
 * @author Michael Roppel
 * @copyright Linux User Group Augsburg (LUGA) e.V. (except "Parsedown" and images).
 *            All images are copyright to their respective owners.
 *            Paresdown: Copyright (c) 2013 Emanuil Rusev, erusev.com
 *                       See LICENSE.txt in includes/Parsedown/
 *
 * @license The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 *********************************************************************************************/

require_once  '../includes/Parsedown/Parsedown.php';
ini_set('Display-Errors', 'on');

$ref = $_GET['ref'];

if (empty($ref))	$ref = 'start/';
$menu = new menu($ref);

$reflist = explode('/', $ref);
$ref_file = array_pop($reflist);

// Falls / aufgerufen wird,dann start.md laden, sonst die HTML-Datei
if(isset($_GET['ref']))	{
	$markdown_file = "../md/$ref.md";
} else {
	$markdown_file = '../md/start.md';
}

// Include-Files
$include_file = "../includes/$ref_file.inc.php";
if (file_exists($include_file)) {
	include_once $include_file;
}
elseif (substr($ref, 0, 16) == 'Treffen/Termine/')	{

	$pd = new Parsedown();
	$pd->setMarkupEscaped(false);

	if(file_exists($markdown_file))	{
		$text = file_get_contents($markdown_file);
	} else {
		// Autogenerierung des MD-Textest
		$data = file('../data/Termine.csv');
		foreach ($data as $line)	{
			if (strstr($line, $ref_file))	{
				$parts = explode('|', $line);
				if (!isset($parts[3]) or empty(trim($parts[3])))	{
					$parts[3] = 'Noch kein Vortrag angekündigt';
				}
				$text = "## Termin und Ort
Mittwoch, $parts[1] per Videokonferenz.<br>
Die Infos zum [Konferenzraum] (/Treffen/Treffpunkt/) werden zuvor bekannt gegeben.<br>
<strike>Mittwoch, $parts[1] im [OpenLab Augsburg](/Treffen/Treffpunkt/)</strike>

## Zeitplan
|||
|-|-|
|__19:00 Uhr__|Beginn|
|__20:00 Uhr__|$parts[3]|
|__anschließend__|Gemütliches Beisammensein und Informationsaustausch|";
			}
		}
	}

	$code = $pd->text($text);

	// externe Links immer in einem separaten Fenster oder Tab öffnen
	$code = preg_replace('/<a href="http(.+?)>/', "<a href=\"http$1 target=\"_blank\">", $code);

} else {
	$pd = new Parsedown();
	$pd->setMarkupEscaped(false);

	//$markdown_file = '../md/index.txt';
	if(!file_exists($markdown_file))	{
		// Fehlerseite laden
		$markdown_file = '../md/error/error404.md';
		// HTTP Header 404 senden
		header("HTTP/1.0 404 Not Found");
	} else {
		$text = file_get_contents($markdown_file);
	}

	$code = $pd->text($text);

	// externe Links immer in einem separaten Fenster oder Tab öffnen
	$code = preg_replace('/<a href="http(.+?)>/', "<a href=\"http$1 target=\"_blank\">", $code);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="/css/luga.css">
<script type="text/javascript" src="/js/luga.js"></script>
<title>LUGA e.V.</title>
</head>
<body>
<div id="main" style="">
		<div class="header">
			<img id="logo" alt="Logo LUGA" src="/images/LUGA_Logo.svg">
			<img alt="Tux" id="tux" style="height: 9em; width: 9em;"
				title="Tux graphic by Larry Ewing, Simon Budig, Anja Gerwinski [Attribution]"
				src="/images/Tux.svg">
		</div>
		<hr>
		<div class="menu">
<?php
// Hauptmenü ausgeben
$menu_entry_list = array();
foreach ($menu->menu as $key => $hauptmenue)	{
	if ($key == $menu->main) {
		$active_h_class = 'class="h-selected"';
	} else {
		$active_h_class = '';
	}
	$link = '/' . $hauptmenue['self']['link'];
	$menu_entry_list[] = "<a $active_h_class href=\"$link\">" .  $hauptmenue['self']['name'] . "</a>\n" ;

}

echo join(' | ', $menu_entry_list);

?>
	</div>
		<div class="submenu">
<?php
// Untermenü Ausgeben
$subname = $menu->sub;
//echo "item: $mainname $subname\n";
$menu_entry_list = array();
foreach ($menu->menu[$menu->main]['sub'] as $key => $submenue)	{
	if($subname == $key)	{
		$active_u_class = 'class="u-selected"';
	} else {
		$active_u_class = '';
	}
	$link = '/' . $submenue['link'];

	$menu_entry_list[] = "<a $active_u_class href=\"$link\">" . $submenue['name'] . "</a>";
}
echo join(' | ', $menu_entry_list);


// Wo bin ich um Home-link ergänzen und das Array umdrehen

?>
	</div>
		<div class="content">
<?php

echo $code;

?>
	</div>
		<div id="footer">
			<a href="/Wir_ueber_uns/Impressum/">Impressum</a> <a href="/Wir_ueber_uns/Datenschutz/">Datenschutz</a>
			<a href="https://www.linogate.de/de/" target="_blank"><img
				src="/images/Linogate_Banner.png" alt="Linogate"></a>
			<a href="https://twitter.com/lug_augsburg" target="_blank"><img
				src="/images/t_small.png" alt="Twitter"></a> <a
				href="https://facebook.com/lugaugsburg" target="_blank"><img
				src="/images/fb_small.png" alt="Twitter"></a>
		</div>
	</div>
</body>
</html>
<?php

/*
 * Tabellengenerator Da markdown keine Tabellen untserstützt ist hier ein einfacher Tabellengeneratur untergebracht,
 * der eine einfache, durch Pipezeichen getrennte Spalten unterstützt. @param string HTML-Code ohne
 * Tabllen @return string HTML-Code mit Tabellen
 */
function tablemaker($code) {
	echo "Tablemaker aktiv";
	$lines = explode ( "\n", $code );

	$flag_table = false;

	/* Tabellenaufbau
!!Headline 1!!Headline2!!Headline 3!!
||Data 1-1||Data 1-2||Data 1-3||
||Data 2-1||Data 2-2||Data 2-3||

Kommt so an:

<p>!!Headline 1!!Headline2!!Headline 3!!
||Data 1-1||Data 1-2||Data 1-3||
||Data 2-1||Data 2-2||Data 2-3||</p>

	 */

	// Liest zeile für zeile und wenn ein Pipe-Zeichen vorkommt, wird eine <tr> erzeugt.
	foreach ( $lines as $n => &$value ) {

		if (substr($value, 0, 3) == '<p>') {
			$identifier = substr($value, 3, 2);
		} else {
			$identifier = substr($value, 0, 2);
		}
		if ($identifier == '!!' or $identifier == '||') {
			// Falls noch keine Tabelle initiiert wurde, dann die vorhergehende Zeile mit einem </p>
			// abschließen und die aktuelle mit einem </p> beginnen
			if(!$flag_table)	{
				$line = "\n<table>\n";
			} else {
				$line = '';
			}

			$flag_table = true;

			switch ($identifier)	{
				case '!!':
					$tr = explode('!!', $value);
					array_shift($tr);
					array_pop($tr);
					//Trimmt den Inhalt von <th>
					$line .= "<tr>\n";

					foreach ($tr as $column)	{
						$column = trim($column);
						list($tag, $column) = inner_tag($column);
						$line .= "<th $tag>$column</th>";
					}
					$line .= "</tr>\n";
					break;

				case '||':
					$tr = explode('||', $value);
					array_shift($tr);
					array_pop($tr);
					// Trimmt den Inhalt von <td>
					$line .= "<tr>\n";

					foreach ($tr as $column)	{
						$column = trim($column);
						list($tag, $column) = inner_tag($column);
						$line .= "<td $tag>$column</td>";
					}
					$line .= "</tr>";
					break;

			}

			$value = $line;
		}
		elseif ($identifier == '++')	{
			if (substr($value, 0, 3) == '<p>') {
				$value = '<p><span class="ib">' . substr($value, 5) . "</span>";
			} else {
				$value = '<span class="ib">' . substr($value, 2) . "</span>";
			}

			$value = str_replace('</p></span>', '</span></p>', $value);

		}
		else {
			if ($flag_table) {
				$value = "</table>\n";
				$line = '';
				$flag_table = false;
			}
		}
	}

	return join("\n", $lines);
}

/* Dient als Analyse eines Spaltentextes
 * Ist im Spatentext ein text zwischen zwei :: eingeschlossen,
 * wird dieser als Tag-Eigenschaft zurück gegeben
 * @pram string Text
 * @returns array (Tag, Text)
 */
function inner_tag($text)	{
	$tag = '';

	$firstpos = strpos($text, '::');
	if ($firstpos !== false) {
		$text = str_replace('&quot;', '"', $text);
		$secondpos = strpos($text, '::', $firstpos + 2);
		$len = $secondpos - $firstpos - 2;
		$start = $firstpos + 2;
		$tag = substr($text, $start, $len);
		$text = str_replace("::$tag::", '', $text);
	}
	return array($tag, $text);
}


function iso_to_date($datum)	{
	// Format YYYY-MM-DD in DD.MM.YYYY wandeln
	$z = explode('-', $datum);
	return $z [2] . '.' . $z [1] . '.' . $z [0];
}


class menu {

	public $menu = array();
	public $main = 'start';
	public $sub = '';
	public $mainitem = '';
	public $subitem = '';

	function __construct($myself) {
		$mypart = explode('/', $myself);
		$this->main = $mypart[0];
		if (isset($mypart[1])) {
			$this->sub = $mypart[1];
		}
		$this->read_menu ( $myself );
	}

	/*
	 * Liest die Menu-Datei und stellt die Hierarchisch MenüStruktur bereit @returns array Menu-Struktur
	 */
	function read_menu($myself) {
		$menu_file = '../menu/menu.csv';
		$fh = fopen ( $menu_file, 'r' ) or die ( 'Failed to open Menu' );

		while ( $line = fgetcsv ( $fh, 0, '|' ) ) {
			$flag_ignore = false;
			$line [0] = trim ( $line [0] );
			if (substr ( $line [0], 0, 1 ) == '#')
				$flag_ignore = true;
			if (empty ( $line ))
				$flag_ignore = true;

			if (! $flag_ignore) {
				$l1 = trim ( $line [0] );
				$l2 = trim ( $line [1] );
				$l2 = substr($l2, 1);

				list($main, $sub) = explode('/', $l2, 3);
				$slash = substr_count($l2, '/');
				if($slash == 1)	{
					$this->menu[$main]['self']['name'] = $l1;
					$this->menu[$main]['self']['link'] = $l2;
				}
				elseif ($slash == 2)	{
					$this->menu[$main]['sub'][$sub]['name'] = $l1 ;
					$this->menu[$main]['sub'][$sub]['link'] = $l2 ;
				}
			}
		}

		fclose ( $fh );
	}
}
