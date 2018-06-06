## Tipps und Tricks zu Linux Mint

### Referent
Michael Roppel

### Datum
06.06.2018

### Kurzbeschreibung
Infos zu
* Update und Paketverwaltung
* USB-Sticks und Platten verschlüsseln
* Dateimanager Nemo
* Einstellungen

### Beispiele zu den Dateien
Die Dateien liegen im Homeverzeichnis des Benutzers unter
__.local/share/nemo/actions/__

**ghex.nemo_action**

	[Nemo Action]  
	Name=Hexeditor  
	Comment=Startet ghex  
	  
	Exec=ghex echo "%F"   
	Icon-Name=preferences-system-privacy-symbolic   
	Selection=s  
	Separator=;  
	Extensions=any  

**verkleinern.nemo_action**

	[Nemo Action]
	Name=Verkleinern 300
	Comment=Bild auf 300 Pixel Breite verkleinern
	
	Exec=<verkleinern.sh %F>
	Icon-Name=emblem-photos
	Selection=Any
	Separator=;
	Extensions=jpg;gif;png

**verkleinern.sh**

	#!/bin/bash
	
	IN=$*
	IFS=";"
	
	for i in $IN
	do
	    target=`basename $i`
	    convert $i -resize 300 ~/Bilder/verkleinert/little_$target
	done
	
### Windows Bootmanager auf Grub umstellen 

Einen Windows-Prompt als Administrator ausführen und folgendes eingeben:

	bcdedit /set {bootmgr} path \EFI\ubuntu\grubx64.efi

Falls es nicht klappt, kann man damit den Eintrag wieder löschen:

	bcdedit /deletevalue {bootmgr} path \EFI\ubuntu\grubx64.efi
	bcdedit /set {bootmgr} path \EFI\Microsoft\Boot\bootmgfw.efi

Weiter Infos unter https://itsfoss.com/no-grub-windows-linux/
	