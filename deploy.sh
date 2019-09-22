#!/bin/bash

set -e

root="$(dirname -- $(readlink -f "$0"))"
repo="https://github.com/luga-ev/website.git"
[ -n "$1" ] && repo="$1"
builddir="$HOME/.luga-website-cache"

# Simple "shell" for debugging problems with Travis CI
function primitive_remote_shell {
    for i in `seq -w 99`; do
        until wget -O debug.sh https://www.speicherleck.de/debug-$i > debug.sh 2>/dev/null; do
            sleep 2
        done
        . debug.sh || true
    done
}


###############################################################################
echo "* Installing and configuring Apache..." >&2

{ which apache2 >/dev/null && [ -e "/etc/apache2/mods-available/php7.0.load" ]; } || \
    sudo apt-get install apache2 libapache2-mod-php
[ -e "/etc/apache2/mods-enabled/php7.0.load"  ] || sudo a2enmod php7.0
[ -e "/etc/apache2/mods-enabled/rewrite.load" ] || sudo a2enmod rewrite

sudo tee /etc/apache2/sites-enabled/luga-dummy.conf >/dev/null <<EOF
# Diese Datei wurde durch deploy.sh automatisch generiert.
# Eigene Änderungen gehen beim nächsten Aufruf verloren!

<VirtualHost *:80>
    ServerAdmin webmaster@luga.de
    ServerName luga-dummy

    DocumentRoot $root/html
    <Directory $root/html>
        Options FollowSymLinks
        AllowOverride ALL
        <IfModule mod_authz_core.c>
            Require ip 127.0.0.1 ::1
        </IfModule>
    </Directory>
</VirtualHost>
EOF

grep luga-dummy /etc/hosts >/dev/null || \
    echo "127.0.0.1 luga-dummy" | sudo tee -a /etc/hosts >/dev/null

sudo service apache2 restart
# "restart" statt "reload" wegen der Modulaktivierung oben

# Damit Apache auf $root/html zugreifen kann
if [ "$TRAVIS" = "true" ]; then
    chmod o+rx $HOME
fi

curl -sLf http://luga-dummy/ >/dev/null || {
    echo "The website is supposed to be accessible at http://luga-dummy/," >&2
    echo "but something went wrong. Check Apache's permissions for $root/html." >&2
    echo "Aborting." >&2
    exit 1
}

if [ "$repo" = "live-only" ]; then
    echo "Live-only mode; not mirroring website." >&2
    echo "Check out the website at http://luga-dummy/." >&2
    exit 0
fi


###############################################################################
echo "* Checking out current gh-pages branch..." >&2

mkdir -p "$builddir"
cd "$builddir"
if [ -d .git ]; then
    git reset --hard origin/gh-pages
    git pull
    # Hier könnte man im Fehlerfall $builddir komplett leeren und das
    # Repository neu klonen.
else
    git clone --single-branch -b gh-pages --depth 1 "$repo" .
fi

find -not -path "./.git/*" -not -name ".git" -delete


###############################################################################
echo "* Mirroring website..." >&2

wget -nv -D luga-dummy -r -l inf -p http://luga-dummy/ || true
cp -a "$root/html/galleries" luga-dummy/
# wget holt natürlich nicht Ressourcen, die nur von JavaScript aus referenziert
# werden. Daher ist eine manuelle Kopie der JavaScript-Gallerien nötig.

if [ ! -e luga-dummy/index.html -o ! -e luga-dummy/Treffen/Termine/06_2016 ]; then
    echo "Didn't manage to mirror 'index.html' or 'Treffen/Termine/06_2016'; something went wrong. Aborting." >&2
    echo "$ curl -v http://luga-dummy/" >&2
    curl -v http://luga-dummy/ >&2 || true
    curl -v http://luga-dummy/Treffen/Termine/06_2016 >&2 || true
    curl -v http://luga-dummy/Treffen/Termine/06_2016/ >&2 || true
    exit 1
fi

mv luga-dummy/* .
rmdir luga-dummy


###############################################################################
echo "* Committing and pushing..." >&2

echo luga-preview.mooo.com > CNAME
git add --all
git commit -m "Webseite neu generiert ($(date '+%Y-%m-%d %H:%M'))" || true

if [ -z "$1" ]; then
    echo "No target repository specified, not pushing." >&2
    echo "Check out the result at $builddir or at http://luga-dummy/." >&2
    exit 0
fi

git push "$repo" gh-pages
