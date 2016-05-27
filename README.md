# Webseite der Linux User Group Augsburg e.V. [![Build Status][travisci-img]][travisci-url]

Der `master`-Branch enthält den Quellcode der Webseite, der `gh-pages`-Branch
die daraus erzeugten statischen Dateien.

Der Continuous-Integration-Dienst [Travis CI][travisci] wird dazu verwendet, die
Seite bei Änderungen im `master`-Branch neu zu bauen und das Ergebnis in
`gh-pages` zu veröffentlichen. Das Schild neben der Überschrift zeigt an, ob
der letzte Buildvorgang erfolgreich war.

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
./deploy.sh
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

# Das Repository auschecken:
git clone git@github.com:luga-ev/website.git
cd website.git

# Änderungen vornehmen:
...

# Optional lokal die statischen HTML-Seiten generieren:
./deploy.sh

# Änderungen mit einer kurzen aussagekräftigen Beschreibung Git bekannt machen:
git commit -a
# Falls neue Dateien hinzugekommen sind, diese vorher mit "git add foobar"
# Git bekannt machen. Der Befehl "git status" ist nützlich, um sich einen
# Überblick zu verschaffen, welche Änderungen Git verfolgt und welche nicht.

# Änderungen hochladen:
git push
# Nach etwa zwei Minuten hat Travis CI die Webseite selbst neu kompiliert und
# den gh-pages-Branch aktualisiert.
```

[gh-webinterface]: https://help.github.com/articles/github-flow-in-the-browser/
[travisci]: https://travis-ci.org/
[travisci-img]: https://travis-ci.org/luga-ev/website.svg?branch=master
[travisci-url]: https://travis-ci.org/luga-ev/website
