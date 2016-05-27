#!/bin/bash

set -e

root="$(dirname -- $(readlink -f "$0"))"
repo="https://github.com/luga-ev/website.git"
[ -n "$1" ] && repo="$1"
builddir="$HOME/.luga-website-cache"

###############################################################################
echo "* Installing and configuring Apache..." >&2

{ which apache2 >/dev/null && [ -e "/etc/apache2/mods-available/php5.load" ]; } || \
    sudo apt-get install apache2 libapache2-mod-php5
[ -e "/etc/apache2/mods-enabled/php5.load"    ] || sudo a2enmod php5
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

###############################################################################
echo "* Checking out current gh-pages branch..." >&2

mkdir -p "$builddir"
cd "$builddir"
if [ -d .git ]; then
    git reset --hard
    git pull
else
    git clone --single-branch -b gh-pages --depth 1 "$repo" .
fi

find -not -path "./.git/*" -not -name ".git" -delete

###############################################################################
echo "* Mirroring website..." >&2

wget -nv -D luga-dummy -r -l inf -p http://luga-dummy/ || true

mv luga-dummy/* .
rmdir luga-dummy

###############################################################################
echo "* Committing and pushing..." >&2

git add --all
git commit -m "Webseite neu generiert ($(date '+%Y-%m-%d %H:%M'))" || true
git push
