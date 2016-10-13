## Backup mit rsync


### Referent
Ingo Bleschmidt

### Datum
04.06.2014

### Kurzbeschreibung
rsync ist ein universelles Werkzeug zur Synchronisation von Dateien &mdash;
sowohl zwischen verschiedenen Speichermedien auf einem einzelnen Rechner als
auch zwischen vernetzten Computern.

Sein Hauptmerkmal ist, dass es Dateien nicht blind kopiert, sondern mit dem
Stand des Ziels vergleicht: Wenn eine zu kopierende Datei schon ganz oder
teilweise beim Ziel vorliegt, kopiert rsync gar nicht oder nur die
fehlenden Teile. Diese zusätzliche Überprüfung macht es bei lokalen Kopien etwas langsamer als konventionelle Archivprogramme, dafür aber bei Übertragungen übers Netz viel schneller.

Im Vortrag werden wir sehen, wie man rsync grundsätzlich auf der Kommandozeile
bedient und wie man rsync für automatisierte Backups einsetzen kann. Die
Besonderheit dabei ist, dass rsync mittels Hardlinks manche Vorteile von
inkrementellen Backups mit denen von vollständigen Backups vereinen kann.

### Skript

* [rsync-backup.sh](/download/Vortraege/rsync-backup.sh)
