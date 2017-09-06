#!/usr/bin/perl

use warnings;
use strict;

# Read the first few bytes of HTTP POST data (if present), to crudely check
# whether the received event pertains to the gh-pages branch.
read STDIN, my $payload, 256;

print "Content-Type: text/plain\015\012Content-Length: 4\015\012\015\012ok\015\012";

chdir "/var/www/www.luga.de/htdocs" or exit;

exit unless defined $payload and $payload =~ /gh-pages/;
exit unless -M ".git" > 30/86400;
# Only update once in thirty seconds.

my $pid = fork();
exit if not defined $pid;  # fork() didn't work
exit if $pid;              # this is the parent

# Sanitize environment (in fear of Shellshock related issues)
%ENV = ();

exec "bash", "-c", <<'EOF';
    {
	git reset --hard origin/gh-pages
	git fetch
	git diff gh-pages origin/gh-pages
	git merge origin/gh-pages
    } 2>&1 | head -n 50000 | mail -s "luga push-hook triggered $(date +'%Y-%m-%d %H:%M')" joerg@luga.de
EOF

# The "head -n 10000" part truncates excessively long diffs to 10000 lines.
