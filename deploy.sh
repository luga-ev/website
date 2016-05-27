#!/bin/bash

set -e

root="$(dirname -- $(readlink -f "$0"))"
repo="git@github.com:luga-ev/website.git"

function cleanup {
    echo "* Cleaning up..." >&2
    [ -n "$builddir" ] && echo rm -rf "$builddir"
}

trap cleanup EXIT

builddir=$(mktemp -d)

###############################################################################
echo "* Installing and configuring Apache..." >&2
{ which apache2 >/dev/null && [ -e "/etc/apache2/mods-available/php5.load" ]; } || \
    sudo apt-get install apache2 libapache2-mod-php5
[ -e "/etc/apache2/mods-enabled/php5.load"    ] || sudo a2enmod php5
[ -e "/etc/apache2/mods-enabled/rewrite.load" ] || sudo a2enmod rewrite

sudo tee /etc/apache2/sites-enabled/luga >/dev/null <<EOF
<VirtualHost *:80>
	ServerAdmin webmaster@luga.de

	DocumentRoot $root/html
	<Directory />
		Options FollowSymLinks
		AllowOverride ALL
	</Directory>
</VirtualHost>
EOF

sudo service apache2 restart
# "restart" statt "reload" wegen der Modulaktivierung oben

###############################################################################
echo "* Checking out current gh-pages branch..." >&2
git clone --single-branch -b gh-pages --depth 1 "$repo" "$builddir"

cd "$builddir"
wget -D localhost -r -l inf -p http://localhost/ || true

mv localhost/* .
rmdir localhost

git add .
git commit -m "Webseite neu generiert $(date '+%Y-%m-%d %H:%M')"

echo $builddir
bash
