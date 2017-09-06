--bgcolor white
--fgcolor black
--title Surfen auf alten PCs und Single-Boardern: Schlanke Webbrowser unter Linux
--author Axel Beckert <abe@debian.org>
--date today %x
--newpage motivation
--heading Motivation
--header Schlanke Webbrowser unter Linux - http://noone.org/talks/vintage/

Firefox und Chromium/Chrome brauchen heutzutage RAM gigabyte-weise: http://www.commitstrip.com/en/scumbag-chrome

Auch webkit-basierte Browser sind nicht besonders sparsam mit Ressourcen.

Soll man alte PCs wegwerfen, nur weil die bekannten Webbrowser zu viel Ressourcen brauchen?

Ist surfen auf 'nem Raspberry Pi 1 Modell A (256 MB RAM) unmöglich?

--newpage NEIN
--sethugefont big
--huge NEIN! :-)

--newpage uebersicht
--heading Ressourcen-freundliche Webbrowser
--ulon
Unter X11
--uloff
* Netsurf
* Dillo
* Links 2

--ulon
Auf der Konsole mit Framebuffer
--uloff
* Netsurf
* Links 2

--ulon
Im Text-Modus
--uloff
* Links 2
* W3m (X11-Support nur zur Anzeige von Bildern)
* Lynx
* ELinks
* Netrik

--newpage netsurf
--heading Netsurf

* Plattenplatz: 4 MB
* RAM-Verbrauch: 104 MB
* Framebuffer-Unterstützung, aber buggy
* GTK
* CSS 2.1
* JavaScript (experimentell; muss explizit eingeschaltet werden)
* Kann als einziger grafischer Browser im Feld Punycode (Umlaut-Domains)
* Tabs
* Eingebauter Adblocker (optional)
* Primäre Plattform: RISC OS (z.B. auf dem Raspberry Pi)
* Auch für BeOS, AmigaOS und MacOS X.
* aktiv entwickelt
* http://www.netsurf-browser.org/

--newpage dillo
--heading Dillo

* Plattenplatz: 1,3 MB
* RAM-Verbrauch: 27 MB
* FLTK (Fast and Light Toolkit)
* CSS (unvollständig)
* Kann kein Punycode (Umlaut-Domains)
* Tabs
* Konfiguration primär über Datei .dillorc
* Anzeige, wieviele Bilder bereits geladen bzw. noch zu laden sind.
* Anzeige der Anzahl von HTML-Fehlern in der Seite
* aktiv entwickelt
* http://www.dillo.org/

--newpage links2
--heading Links 2

* Plattenplatz: 3 MB (inklusive vielen Lokalisierungen)
* RAM-Verbrauch: 20 MB
* X11, Framebuffer, LibSVGA (in Debian/Ubuntu deaktiviert) und Text-Modus
* Fork von Links 0.9x
* Debian/Ubuntu: "links" ohne und "links2" mit Grafikunterstützung
* Kann kein Punycode (Umlaut-Domains)
* Kann mehrere Fenster in einem Prozess, keine Tabs
* Macht im Text-Modus unter X ein neues Terminal als neues Fenster auf.
* Ignoriert Locales-Einstellungen
* Sprache und Zeichensatz müssen in der Anwendung konfiguriert werden.
* aktiv entwickelt
* http://links.twibright.org/

--newpage w3m
--heading W3m

* Plattenplatz: 2,1 MB + 179 kB (Unterstützung von Bildern)
* RAM-Verbrauch: 10 MB + 7 MB (Unterstützung von Bildern)
* Text-Modus plus Anzeige von Bildern unter X11
* Bei Debian/Ubuntu: Anzeige von Bildern durch Paket "w3m-img"
* Kann kein Punycode (Umlaut-Domains)
* Pfeiltasten bewegen Cursor durch Inhalt statt von Link zu Link.
* http://w3m.sf.net/

--newpage lynx
--heading Lynx

* Plattenplatz: 4,9 MB
* RAM-Verbrauch: 11 MB
* Nur Text-Modus
* Älter als das WWW (!); entwickelt seit 1992.
* Kann Punycode (Umlaut-Domains)
* Unterstützt auch Gopher.
* Vorbild für viele der anderen Text-Browser (vgl. Tastatur-Befehle)
* Verschiedene Einstellungen für Anfänger, Fortgeschrittene und Profis
* Farben über Lynx Style-Sheets (LSS) anpassbar.
* aktiv entwickelt
* http://lynx.invisible-island.net/

--newpage elinks
--heading ELinks

* Plattenplatz: 1,4 MB
* RAM-Verbrauch: 17 MB
* CSS (auf Linux-Konsole und 256-Farben-XTerm)
* Nur Text-Modus
* Fork von Links 0.9x
* Kann im Gegensatz zu Links2 Punycode (Umlaut-Domains)
* Unterstützt auch Gopher.
* Zeigt Webseitentitel auch im Fenstertitel des Terminals an.
* Nutzt mehr Farben auf der Linux-Konsole als Links 2.
* Farben auch beim "Dumpen" möglich.
* Letztes Beta-Release vor >3 Jahren, letztes Stable-Release vor >6 Jahren
* http://elinks.cz/

--newpage netrik
--heading Netrik

* Plattenplatz: 655 kB
* RAM-Verbrauch: 4,3 MB
* Nur Text-Modus
* Kein HTTPS und kein Punycode.
* Nutzt viel ANSI-Farben und Sonderzeichen zur Darstellung
* Letztes Release vor 6 Jahren.
* http://netrik.sf.net/

--newpage zusammenfassung
--heading Zusammenfassung und Fazit

* Selbst mit einem 20 Jahre alten PC kann man noch im Web surfen.
* Vergesst JavaScript und Flash
  (Vergesst Letzteres sowieso: http://occupyflash.org/ ;-)
* Je schlanker der Browser desto unansehlicher die Darstellung.
* Netrik wird's schwer haben ohne HTTPS (Snowden, Let's Encrypt, ...)
* Welcher Webbrowser der Richtige[TM] ist, ist Geschmackssache.

--newpage links-und-danke
--heading Links und Danke

--ulon
Links
--uloff
* Folien zum Vortrag: http://noone.org/talks/vintage/
* Geschichte von Links und seinen Derivaten: http://elinks.cz/history.html

Zeitschriftenartikel zu diesem Thema erschienen in
* Linux-User 02/16: Abgespeckt - Schlanke Webbrowser unter Linux
* Raspberry Pi Geek 02/16: Abgespeckt - Schlanke Webbrowser unter Raspbian
--## http://www.linux-community.de/Internal/Artikel/Print-Artikel/LinuxUser/2016/02/Abgespeckt
--## http://www.raspberry-pi-geek.de/Magazin/2016/02/Schlanke-Webbrowser-unter-Raspbian

--ulon
Danke
--uloff
* an Jörg Luther vom Linux-User Magazin für die Idee zu diesem Thema;
* an Andreas Krennmair, Nico Golde und Sven Guckes für TPP;
* an Euch fürs Interesse und Zuhören.
