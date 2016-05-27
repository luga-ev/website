<?php
/*****************************************************
 * Anzeige der Terminliste
 * ***************************************************/

// Markdown am oberen Teil der Datei
require_once '../includes/Parsedown/Parsedown.php';
$pd = new Parsedown();
$data = file_get_contents('../md/Termine.md');
$code = $pd->text($data);


$data = file_get_contents('../data/Termine.csv');
$lines = explode("\n", $data);

unset($data);

$code .= "<table>\n";

foreach ($lines as $termin) {
	$cols = explode('|', $termin);
	array_pop($cols);
	array_shift($cols);

	// Falls nur eine Spalte, dann als h3 interpretieren
	if (count($cols) == 1)	{
		$code .= "<tr><td><h3>" . $cols[0] . "</h3></td></tr>\n";
	} else {
		$code .= "<tr>";
		foreach ($cols as $key => $td)	{
			if ($key < 2)	{
				$code .= "<td class=\"nowrap\">" . $td . "</td>";
			} else {
				$code .= "<td>" . $td . "</td>";
			}
		}
		$code .= "</tr>\n";
	}
}

$code .= "</table>\n";
