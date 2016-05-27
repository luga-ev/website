<?php

header('Content-Type: text/plain; charset=UTF-8');
$dir = '/home/michael/Antares/Projekte/luga_backup/Treffen/Termine';
$dest = '/home/michael/Antares/html/luga/md/Treffen/Termine';

$a = scandir($dir);
foreach ($a as $entry)	{
	if (substr($entry, -2, 2) == '.1')	{
		$subject = file_get_contents("$dir/$entry");
		//echo $subject;
		$subject = preg_match('/<div class="Desktop">.+?<\/div>/s', $subject, $matches);
		$subject = $matches[0];
		$subject = str_replace('<div class="Desktop">', '', $subject);
		$subject = str_replace('</div>', '', $subject);
		$subject = str_replace('<span>', '', $subject);
		$subject = str_replace('</span>', '', $subject);
		$subject = str_replace(' class="indent"', '', $subject);
		$subject = str_replace('<center style="font-weight:bold;">', '', $subject);
		$subject = str_replace('</center>', '', $subject);
		$subject = preg_replace('/ +/', ' ', $subject);
		$subject = trim($subject);
		$subject = utf8_encode($subject);

		$entry = str_replace('.1', '.md', $entry);
		$target = "$dest/$entry";
		echo "$target\n";
		file_put_contents($target, $subject);
	}
}

