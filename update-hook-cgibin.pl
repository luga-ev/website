#!/usr/bin/perl
# Trivial CGI script to fetch the current version of the website

use warnings;
use strict;

print "Content-Type: text/plain\015\012Content-Length: 4\015\012\015\012ok\015\012";

my $pid = fork();
exit if not defined $pid;  # fork() didn't work
exit if $pid;              # this is the parent

# Sanitize environment (in fear of Shellshock related issues)
%ENV = ();

exec "bash", "-c", <<'EOF';
    {
	cd /var/www/luga-preview
	git reset --hard origin/gh-pages
	git pull --rebase
    } 2>&1 | mail -s "luga push-hook triggered $(date +%Y-%m-%d %H:%M)" iblech@speicherleck.de
EOF
