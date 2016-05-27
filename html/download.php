<?php
/*******************************************************
 * Download-Modul
 *******************************************************/

// Datei für den Download wurde als Parameter übergeben
$ref = $_GET['ref'];

// sanitize
// Kann normalerweise eigentlich nicht vorkommen, wäre aber duch Direktaufruf möglich
$ref = str_replace('../', '', $ref);
$filename = "../download/$ref";

// Prüfen, ob Datei existiert; sonst 404 senden
if (file_exists($filename))	{

	$size = filesize($filename);

	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type =  finfo_file($finfo, $filename) . "\n";
	finfo_close($finfo);
	header("Content-Type: $mime_type");
	header("Content-Length: $size");
	readfile($filename);
} else {
	// Sendet die 404
	include 'index.php';
}


