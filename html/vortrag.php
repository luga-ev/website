<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Vorträge übernehmen</title>
</head>
<body>
<h1>Vorträge übernehmen</h1>
<pre>
<?php 

ini_set('Display-Errors', 'On');

$myVortrag = new vortrag();


class vortrag {
	
	private $removable = array(
			'Pinguin',
			'corner_bl',
			'corner_br',
			'corner_tl',
			'corner_tr',
			'corner_top',
			'edge_top',
			'line_t',
			'onepixel',
			'LUGA_Logo',
	);
	
	private $init_path = '/home/michael/Antares/Projekte/luga/Angebote/Vortraege';

	function __construct()	{
		$this->listdir($this->init_path, '');
	}
	
	function listdir($path, $dirname)	{
		
		$entries = scandir($path);
		foreach ($entries as $file)	{
			if(strlen($file) > 2)	{
				if(is_dir("$path/$file"))	{
					$this->listdir("$path/$file", $file);
				} else {
					// überflüssgie entfernen
					foreach ($this->removable as $remfile)	{
						if($file == $remfile)	{
							unlink("$path/$file");
							echo "killed $path/$file\n";
							break;
						}
					}
					
					// Falls der Dateiname index ist, dann Umbenennung vornehmen
					if ($file == 'index.html') {
						if(!empty($dirname))	{
							if(file_exists("$this->init_path/$dirname" . ".1"))	{
								unlink("$path/$file");
								echo "killed $path/$file\n";
							} else {
								if(!rename("$path/$file", "$this->init_path/$dirname" . ".1"))	{
									echo "ERROR in rename $path/$file in $this->init_path/$dirname" . ".1 !!!\n";
								} else { 
									echo "renamed $path/$file in $this->init_path/$dirname" . ".1\n";
								}	
							}
						}
					}
					echo "$path/$file\n";
				}
			}
		}
	}
	
}

?>
</pre>
</body>
</html>