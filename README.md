# Webseite der Linux User Group Augsburg e.V. [![Build Status][travisci-img]][travisci-url]

Der `master`-Branch enthält den Quellcode der Webseite, der `gh-pages`-Branch
die daraus erzeugten statischen Dateien.

Der Continuous-Integration-Dienst [Travis CI][travisci] wird dazu verwendet, die
Seite bei Änderungen im `master`-Branch neu zu bauen und das Ergebnis in
`gh-pages` zu veröffentlichen. Das Schild neben der Überschrift zeigt an, ob
der letzte Buildvorgang erfolgreich war.

Die Webseite ist unter https://www.luga.de/ verfügbar.

## Änderungen

Kleinere Änderungen kann man sehr gut im [GitHub Webinterface][gh-webinterface]
vornehmen, dazu benötigt man nur einen (kostenlosen) Account bei GitHub. Dabei
muss nichts installiert werden. Die Webseite wird dann automatisch von Travis CI
neu gebaut.

Wer keine Schreibrechte auf das Repository hat, kann Änderungen in Form eines
Pull Requests einreichen. (Das schlägt GitHub auch von selbst vor, wenn man
über das Webinterface editiert.) Wer Schreibrechte möchte, muss sich nur melden.


## Lokal ausprobieren

Wer die Webseite auf seinem eigenen Computer generieren möchte (etwa, um
Änderungen zu begutachten bevor sie veröffentlicht werden), muss dazu nur
folgende drei Befehle ausführen:

```shell
git clone https://github.com/luga-ev/website.git
cd website
./deploy.sh live-only
```

Dazu muss das Programm `git` zwar installiert, aber nicht eingerichtet sein.
Das Skript kümmert sich um die Installation und Einrichtung des
Apache2-Webservers.

Achtung: Das Skript macht sich bei Apache-Versionen vor 2.4 nicht die Mühe, den
Zugriff von externen IP-Adressen aus abzuschotten.

Wer bisher Git nicht konfiguriert hat, die LUGA-Webseite aber zum Anlass nehmen
möchte, um das nachzuholen, kann nach folgendem Plan vorgehen.

```shell
# Git mitteilen, womit eigene Commits annotiert werden sollen:
git config --global user.email "emmy@noether.de"
git config --global user.name "Emmy Noether"
# Und nicht vergessen, den eigenen SSH-Schlüssel (generierbar mit ssh-keygen)
# in GitHub zu authorisieren.

# Das Repository auschecken:
git clone git@github.com:luga-ev/website.git
cd website.git

# Änderungen vornehmen:
...

# Optional:
./deploy.sh live-only  # lokal den Webserver starten oder
./deploy.sh            # sogar die statischen Seiten neu generieren

# Änderungen mit einer kurzen aussagekräftigen Beschreibung Git bekannt machen:
git commit -a
# Falls neue Dateien hinzugekommen sind, diese vorher mit "git add foobar"
# Git bekannt machen. Der Befehl "git status" ist nützlich, um sich einen
# Überblick zu verschaffen, welche Änderungen Git verfolgt und welche nicht.

# Änderungen hochladen:
git push
# Nach etwa zwei Minuten hat Travis CI die Webseite selbst neu kompiliert und
# den gh-pages-Branch aktualisiert. Sollte Travis CI aus irgendeinem Grund
# nicht funktionieren, kann man auch lokal die statischen Seiten erzeugen und
# hochladen:
# ./deploy.sh git@github.com:luga-ev/website.git
```

## Webseite für den Linux-Infotag

Die Webseite für den Linux-Infotag ist seit dem LIT 2023 eine eigene,
unabhängige statische Webseite. Eine eigene Webseite erlaubt es das Programm,
die Vorträge und Stände besser auf mehrere Seiten zu verteilen und besser
darzustellen.

Der Quellcode für die LIT Webseite (ab LIT-2023) ist in separaten Repositories
([LIT-2023](https://www.luga.de/static/LIT-2023/)). In diesen Repos finden sich
auch Infos wie die Webseiten gebaut und angepasst werden können. Die
generierte, statische Webseite wird dann in den Ordner `static/html` kopiert,
die Webseite ist dann verfügbar unter z.B.
[www.luga.de/static/LIT-2023/](https://www.luga.de/static/LIT-2023/).

Zusätzlich sollte noch ein Redirect von
[www.luga.de/Aktionen/LIT-2023/](https://www.luga.de/Aktionen/LIT-2023/) auf
die eigentliche Seite gesetzt werden. Das dient dazu das bisherige Link-Schema
nicht zu brechen. Zum Einrichten des Redirects bitte joergl fragen.

[gh-webinterface]: https://help.github.com/articles/github-flow-in-the-browser/
[travisci]: https://travis-ci.com/
[travisci-img]: https://app.travis-ci.com/luga-ev/website.svg?branch=master
[travisci-url]: https://app.travis-ci.com/github/luga-ev/website
