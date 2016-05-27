--bgcolor white
--fgcolor black
--title Augsburger Linux-Infotag 2012
--title APT - Advanced Packaging Tool
--title Paketverwaltungssystem fuer Debian GNU-Linux 
--color blue
--author Thomas Winde <ausflug@web.de>
--color black
--center 24. Maerz 2012
--color red
--withborder
--newpage
--header 11. ALIT 2012:  APT - Advanced Packaging Tool
--color red
--withborder
--heading Inhalt
---

--color blue
--center Die Vortragenden

---
--center Geschichte von APT

---
--center Grundinstallation: Das APT-Paket

---
--center Werkzeuge zur Konfiguration von APT

---
--center apt-get - Befehl

---
--center apt-cache - Befehl

---
--center aptsh - Paket

---
--center apt-file - Paket

---
--center diverse APT-Werkzeuge

--newpage
--color red
--withborder

--heading Die Vortragenden: Thomas Winde

 * aktiv in der Chemnitzer Linux User Group (CLUG)

 * Mitorganisation der Chemnitzer Linux-Tage
   - Betreuung des Einsteigerforums
   - Sponsor und Tagungsfahrdienst

---
 * Thomas Winde Ausflugsfahrten
   - Ausflugsfahrten
   - Mietfahrten
   - Flughafenzubringer
   - Guetertaxi
   - Fahrten zu Linux-Veranstaltungen

--newpage
--color red
--withborder

--heading Die Vortragenden: Frank Hofmann

 * Mitorganisation des Brandenburger Linux-Infotag (BLIT) (seit 2006)

 * Kooordinator des Regionaltreffens der Linux User Groups aus Berlino
   und dem Berliner Umland (seit 2008)

 * Hofmann EDV - Linux, Layout und Satz
   Systemadministration (Debian)
   Druckvorstufe und -vorbereitung
   WLAN-Komponenten f√?r den Innen- und Au√üeneinsatz

   Standort/Sitz:o
   Open Source Buerogemeinschaft Buero 2.0 in Berlin-Neukoelln
   stellv. Vorstand des Buero 2.0 e.V. i.G.

 * Fachautor f√?r das Magazin LinuxUser

--newpage
--color red
--withborder

--heading Geschichte von APT 

---
--color black
Am Anfang war das .tar.gz
jeder Benutzer musste die Programme selbst kompilieren

---
Mit Beginn des Debianprojektes entstand die Idee
vorkompilierte Pakete bereitzustellen dafuer wurde
dpkg entwickelt was immernoch im Hintergrund arbeitet

---
Danach entschied sich Red Hat sein RPM-System zu erstellen

---
--color blue
Die Abhaengigkeiten der Pakete fuehrte zur Entwicklung von
APT - Advanced Packaging Tool als Bedienoberflaeche fuer dpkg

---
Danach entstanden weitere Oberflaechen fuer APT und dpkg

--newpage
--color red
--withborder
--heading Grundinstallation: Das APT-Paket

---
--color blue
Bei der Installation von Debian GNU-Linux wird das
APT-Paket mitinstalliert es enthaelt die apt-get-Befehle,
---
die apt-cache-Befehle und die entsprechenden Einstellungen

--color magenta
Weitere Apt-Werkzeuge bzw. Pakete koennen dann bei Bedarf
installiert werden

--newpage
--color red
--withborder
--heading Werkzeuge zur Konfiguration von APT

---
--color blue
Konfigurationsdateien stehen unter /etc/apt/
/etc/apt/sources.list - Quellenverzeichnis

---
Typ Quelle Distribution Komponenten
--##deb deb-src
--##file http ftp cdrom
--##stable... oder Name
--##main contrib non-free
---
--color magenta
apt-cdrom - CD/DVD einbinden
---
netselect-apt - HTTP/FTP-Quellen einbinden
---
Texteditor - um von Hand die Quellen zu bearbeiten

---
--color blue


---
--newpage
--color red
--withborder
--heading apt-get - Befehl
---
--color blue

Benutzerschnittstelle zur Verwaltung von Paketen

---
--color magenta
Kommandos:
update - aktualisieren der Paketdatenbank
---
upgrade - Pakete aktualisieren
---
install - Pakete installieren
---
remove - Pakete entfernen
---
purge - Pakete restlos entfernen
---
dist-upgrade - gesamte Distribution aktualisieren
---
clean/autoclean - Wartung des lokalen Archivs
---
source - Quelldateien herunterladen
---
autoremove - automatisch installierte Pakete entfernen
--newpage
--color red
--withborder
--heading apt-cache - Befehl

---
--color blue
Apt-Werkzeug zur Handhabung von Paketen
---
--color magenta
search - Volltextsuche in Paketen und Beschreibungen
---
show - Paketinformation anzeigen
---
stats - Statistik des Paketzwischenspeichers
---
showpkg - Paketabhaengigkeiten anzeigen
---
policy - Paketversionen und Prioritaeten anzeigen
---
depends - Paketliste die von einem Paket abhaengen
---
rdepends - Pakete die das Paket benoetigen
---
pkgnames - alle Paketnamen die APT kennt
---
madison - tabellarische Paketinformationen
--newpage
--color red
--withborder
--heading aptsh - Paket

---
--color blue
Interaktive Apt-Shell (apt-get und apt-cache)

--color magenta
- Aptsh hilft bei der Verwaltung von Paketen
- nette Pseudo-Shell mit Autovervollstaendigung
- vereinfachter Zugriff auf die Apt-Befehle
- Zusaetzliche Faehigkeiten:
Befehlswarteschlange und ein Sucher nach verwaisten Paketen 
--newpage
--color red
--withborder
--heading apt-file - Paket

---
--color blue
Suchwerkzeug fuer alle Pakete
---

--color magenta
update - apt-file-Datenbank aktualisieren
---

search - sucht das Paket in welchem Datei enthalten
---

list - zeigt den Inhalt eines Paketes an (alle Dateien)
---

purge - loescht den lokalen Paketspeicher
--newpage
--color red
--withborder
--heading diverse apt-Werkzeuge

---
--color blue
apt-show-versions - listet verfuegbare Paket-Versionen
apt-key - Paketsicherheit
apt-listbugs - kritische Fehler in Paketen
verschiedene Apt-Werkzeuge zur Erstellung von Paket-CDs,
von eigenen Mirrorn und Debianpaketen

---
--color magenta
aptitude - erweitertes Befehlszeilenwerkzeug und auch
mit ncurses-Oberflaeche (ohne X)

---
synaptic - X-Oberflaeche fuer APT

---
Software-Center - andere Oberflaeche fuer Synaptic
--newpage
--color red
--withborder
--heading Erweiterung zu apt und dpkg - das debtags-Projekt
--color blue
Projektwebseite: http://debtags.debian.net/
* Idee: Debian-Pakete werden mit Schlagwoertern versehen
  Beispiele f√?r Schlagwoerter ("Tags"):
  interface::x11         - X-Programm
  implemented-in::python - in der Sprache Python programmiert
  interface::commandline - Kommandozeilenprogramm

  Liste der Schlagw√∂rter: http://debtags.debian.net/exports/stable-tags
* ben√∂tigte Debian-Pakete: debtags und grep-dctrl
  Suchen √?ber die Schlagw√∂rter: Programm grep-debtags aus grep-dctrl
* Beispielaufruf:
  den Namen aller Pakete auflisten, die der Kategorie Webbrowser
  zugeordnet sind und keine KDE-Bibliotheken ben√∂tigen

  grep-debtags -d -s Package web::browser -a -! suite::kde
--newpage
--color red
--withborder
--heading Quellverzeichnis

---
--color blue

Heike Jurzik - Debian GNU-Linux

Wikipedia - APT-Eintrag

diverse Manpages der APT-Programme
--newpage


--color red
--withborder
--heading Fragen???
---


EEEEE  N   N  DDDD   EEEEE
E      NN  N  D   D  E
EEEE   N N N  D   D  EEEE
E      N  NN  D   D  E
EEEEE  N   N  DDDD   EEEEE
--color black


   ...vielen Dank fuers zuhoeren :-)
   
-- 
 Ihr WEB.DE Postfach immer dabei: die kostenlose WEB.DE Mail App f¸r iPhone und Android.
https://produkte.web.de/freemail_mobile_startseite/
