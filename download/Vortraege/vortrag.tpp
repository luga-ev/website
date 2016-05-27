--bgcolor white
--fgcolor black
--title vim lernen und Linux nutzen
--color blue
--author Frank Hofmann <frank.hofmann@efho.de>
--author Thomas Winde <ausflug@web.de>
--color black
--center 26. März 2011 - 10. Linux-Infotag Augsburg
--color red
--withborder


---
--center  Wir sind beide vim-Benutzer und fanden Programme, wo unser
--center  vim-Wissen nützlich war. Ist das gewollt?

---
--center  Wir stellen Euch Programme vor, die sich mit den 
--center  vim-Tastenkombinationen und -Konzepten bedienen lassen.


---
--center  Wir - das sind:

--newpage
--header Vortrag am 26. März 2011: Vim lernen und Linux nutzen

--color blue
--withborder
--color red
--heading Die Vortragenden

--color blue
 Frank Hofmann

 * im Vorstand der Linux User Group Potsdam (upLUG)

---
 * Mitorganisation
   Chemnitzer Linux-Tage (2000-2007)
   Brandenburger Linux-Infotag (BLIT) (seit 2006)
 
---
 * LinuxBus

---
 * Regionaltreffen der Linux User Groups aus Berlin und dem
   Berliner Umland (seit 2008)
   

--newpage
--color blue
--withborder
--color red
--heading Die Vortragenden

--color blue
 Frank Hofmann

 * Hofmann EDV - Linux, Layout und Satz
   Systemadministration (Debian)
   Druckvorstufe und -vorbereitung
   WiFi-Komponenten

---
 * Wizards of FOSS (Mitbegründer)
   Open Source Schulungen - von Experten für Experten

---
 Standort/Sitz:
 Büro 2.0 Berlin-Neukölln
 Open Source Bürogemeinschaft

--newpage
--color blue
--withborder
--color red
--heading Die Vortragenden

--color blue
 Thomas Winde

 * Chemnitzer Linux User Group (clug)

---
 * Mitorganisation
   Chemnitzer Linux-Tage (seit 2001)
   - Betreuung des Einsteigerforums
   - Sponsor und Tagungsfahrdienst

---
 * Unternehmen
   Thomas Winde Ausflugsfahrten
   - Ausflugsfahrten
   - Mietfahrten
   - Flughafenzubringer
   - Gütertaxi
   - Fahrten zu Linux-Veranstaltungen
   
 Standort: 09114 Chemnitz

--newpage
--color red
--withborder
--heading Inhalt

--color blue

 * Von vi zum vim
 * vi-Klone und Derivate
 * Plugins
 * PDF-Betrachter
 * Tabellenkalkulation
 * Warenwirtschaft / Kundenverwaltung
 * Paketverwaltung
 * Webbrowser und Erweiterungen
 * Werkzeuge
 * Multimedia
 * Sonstiges
 * Danksagung

--newpage
--color blue
--withborder
--color red
--heading Von vi zum vim
--color blue

 vim

 Homepage:     http://www.vim.org
 Debian-Paket: http://packages.debian.org/squeeze/vim

 * erweiterte Version des vi
 * vim = vi improved ("verbesserter vi")
 * 1991 entwickelt von Bram Moolenaar für AMIGA
 * heute auf allen UNIX-/Linux-Systemen und Apple OS X enthalten.


---
 gvim

 Homepage:     http://www.vim.org
 Debian-Paket: http://packages.debian.org/squeeze/vim-gtk

 * vim-Editor in graphischer Ausführung
 
--newpage
--color blue
--withborder
--color red
--heading vi-Klone und Derivate (1)
--color blue

 nvi

 Debian-Paket: http://packages.debian.org/squeeze/nvi

 * Neuimplementierung von vi auf 4.4 BSD (FreeBSD und NetBSD)


---
 elvis

 Debian-Paket: http://packages.debian.org/squeeze/elvis

 * Standardeditor auf Slackware Linux, Kate OS und MINIX

 
--newpage
--color blue
--withborder
--color red
--heading vi-Klone und Derivate (2), Plugins
--color blue

 vile

 Debian-Paket: http://packages.debian.org/squeeze/vile

 * Akronym vile steht für "VI Like Emacs"
 * Versuch, beide Welten miteinander zu vereinen
 * erweiterbar um Perl-Interpreter


---
 Plugins für verschiedene Entwicklungsumgebungen
 
 * Eclipse-Erweiterung: vim-Bedienung

 * vim-Erweiterung: Eclipse-Fähigkeiten (eclim)

 * Erweiterung für die Microsoft-Produkte Visual Studio, Word, Outlook 
   und SQL Server
 
--newpage
--color blue
--withborder
--color red
--heading PDF-Betrachter
--color blue

 Zathura

 Homepage:     http://pwmt.org/projects/zathura
 Debian-Paket: http://packages.debian.org/squeeze/zathura

 * benannt nach dem gleichnamigen Film "Zathura - Ein Abenteuer im 
   Weltraum" (2005)
 * minimalistischer Ansatz 
   klein, hochgradig anpassbar, Beschränkung auf das Wesentliche
   Bedienung über die Tastatur


---
 apvlv

 Homepage:     http://code.google.com/p/apvlv/
 Debian-Paket: http://packages.debian.org/squeeze/apvlv

 * Abkürzung für Alf's PDF viewer like vim
 * kleine Unterschiede zu Zathura (Bedienung)
 * integrierte Hilfe

 
--newpage
--color blue
--withborder
--color red
--heading Tabellenkalkulation
--color blue

 sc

 Homepage:     ftp://metalab.unc.edu/pub/Linux/apps/financial/spreadsheet
 Debian-Paket: http://packages.debian.org/squeeze/sc

 * sc steht für Spreadsheet Calculator
 * viele nutzen große Office-Tabellenkalkulationen - das geht auch 
   auf der Kommandozeile
 * Bedienung sehr stark an vim angelehnt

 
--newpage
--color blue
--withborder
--color red
--heading Warenwirtschaft / Kundenverwaltung
--color blue

 nanowawi

 Homepage:     http://sourceforge.net/projects/nanowawi/
 Ubuntu-Paket: http://launchpad.net/~dholbach/+archive/ppa
 Debian-Paket: hat noch keiner gebaut!

 * textbasierte Warenwirtschaft für kleine und mittlere Unternehmen (KMU)
 * nanowawi = kleine Warenwirtschaft
 * programmiert in Python

--newpage
--color blue
--withborder
--color red
--heading Paketverwaltung
--color blue

 aptitude

 Debian-Paket: http://packages.debian.org/squeeze/aptitude
 
 * terminalbasierter Paketmanager für deb-Pakete
 * setzt auf den Kommandozeilenwerkzeugen apt und dpkg auf
   (Erweiterung von apt um textbasierte Oberfläche)
 * Basis: curses-Framework

 * selbstironische Beschreibung: 
   Jahr-2000-kompatibel, nicht fettend, selbstreinigend und stubenrein

--newpage
--color blue
--withborder
--color red
--heading Webbrowser und Erweiterungen (1)
--color blue

  uzbl

  Homepage:     http://uzbl.org/
  Debian-Paket: http://packages.debian.org/squeeze/uzbl

  * Webbrowser, der konsequent der Unix-Philosophie folgt
  * Konzentration auf eine einzige Aufgabe -- das Darstellen von Webseiten -- 
    dafür aber richtig
  * nicht enthalten:
    Lesezeichen und deren Verwaltung
    Liste der bereits besuchten Seiten
    Liste der Downloads

    ergänzbar durch eigene Shellskripte

  * Basis: WebKit
    Entwicklungsplattform für Webanwendungen

--newpage
--color blue
--withborder
--color red
--heading Webbrowser und Erweiterungen (2)
--color blue

  w3m

  Homepage:     http://w3m.sourceforge.net
  Debian-Paket: http://packages.debian.org/squeeze/w3m

  * Textbrowser
  * Darstellung der Webseite erfolgt im Terminal
    Darstellung richtet sich nach den Fähigkeiten des Terminals


---
  wmii - window manager improved 2

  Homepage:     http://wmii.suckless.org/
  Debian-Paket: http://packages.debian.org/squeeze/wmii

  * leichtgewichtiger Fenstermanager für X11
  * bedienbar mit der Tastatur und der Maus
  * Reduktion auf das Wesentliche

--newpage
--color blue
--withborder
--color red
--heading Webbrowser und Erweiterungen (3)
--color blue

  Vimperator

  Homepage:     http://vimperator.org/vimperator
  Debian-Paket: http://packages.debian.org/vimperator

  * Plugin für den Firefox
  * Tastaturbedienung des Firefox über vim-Kommandos


---
  Pentadactyl

  Homepage:     http://dactyl.sourceforge.net/pentadactyl
  Debian-Paket: noch keins gebaut!

  * Plugin für den Firefox
  * Pentadactyl ist der Nachfolger von Vimperator

--newpage
--color blue
--withborder
--color red
--heading Werkzeuge (1)
--color blue

  vifm

  Homepage:     http://vifm.sourceforge.net
  Debian-Paket: http://packages.debian.org/squeeze/vifm

  * Dateimanager mit vim-Kommandos


---
  ranger

  Homepage:     http://ranger.nongnu.org
  Debian-Paket: http://packages.debian.org/wheezy/ranger 
                (noch zu neu, daher in Debian Testing)

  * Dateimanager mit vim-Kommandos

--newpage
--color blue
--withborder
--color red
--heading Werkzeuge (2)
--color blue

  bvi - binary vi

  Homepage:     http://bvi.sourceforge.net/
  Debian-Paket: http://packages.debian.org/de/squeeze/bvi

  * Binär-Editor
  * Darstellung des Bytestroms ohne Zeilenenden
  * unterstützte Bitoperationen
    AND, OR, XOR, NEG, NOT
    Rotationen und Shifts


---
  less

  * Ersatz für den UNIX-Standard-Pager
  * "less is more"

--newpage
--color blue
--withborder
--color red
--heading Multimedia
--color blue

  cmus - console music player

  Homepage:     http://cmus.sourceforge.net/
  Debian-Paket: http://packages.debian.org/squeeze/cmus


---
  ncmpc

  Debian-Paket: http://packages.debian.org/squeeze/ncmpc

  * Basis: ncurses-Framework
  * spielt ab:
    Ogg Vorbis, MP3 (über libmad), FLAC, WAV, AAC, 
    Windows Media Audio (WMA)

--newpage
--color blue
--withborder
--color red
--heading Sonstiges
--color blue

  * viele tastenkombinationen sind "recyclebar"
    Beispiel: Suche mit "/"
              in Firefox/Iceweasel, aptitude, less usw.

---
  * bash mit vi-Modus

---
  * komplette Zusammenstellung zu vi/vim von Sven Guckes: 
    The Vi Editor and its clones and programs with a vi like interface
    http://www.guckes.net/vi/index.php3

---
  * Webseite für Zusammenstellung (LinuxWiki)
    http://linuxwiki.de/vi-keybindings

--newpage
--color blue
--withborder
--color red
--heading Danksagung
--color blue

  Lieben Dank für Anregungen, Kommentare und Kritik:

  * Sven Guckes

  * Axel Beckert



--newpage
--color blue
--withborder
--color red
--heading Vielen Dank!

 Noch Fragen?

---
--color blue

              ooooo  o   o  oooo   ooooo
              o      oo  o  o   o  o
              oooo   o o o  o   o  oooo
              o      o  oo  o   o  o
              ooooo  o   o  oooo   ooooo

---
                     ... und vielen Dank fürs zuhören sagen


--center  Frank Hofmann  und  Thomas Winde
   
