#!/usr/bin/perl -i -pw
# Sehr einfach gestricktes Skript, um in Textdateien HTTP- in HTTPS-Links zu
# ersetzen. Mit curl wird geprüft, ob die HTTPS-Alternativen funktionieren.
#
# Aufruf: ./rewrite-http-to-https.pl text1.txt text2.txt ...
#
# Oder parallel: for i in *.txt; do ./rewrite-http-to-https.pl "$i" & sleep 0.1; done

sub check_link {
    system(qw< curl -L -m 30 -f -o /dev/null -s -- >, $_[0]) == 0;
}

sub http2https {
    my $str = shift;
    $str =~ s#^http://#https://#;
    return $str;
}

s#(http://.*?)([\s\)\]}"<>])#
    my $url       = $1;
    my $delimiter = $2;

    print STDERR "... $url";

    if(not check_link($url)) {
        print STDERR "\033[2K\r404 $url\n";
    } else {
        print STDERR "\033[2K\r... $url";
        if(check_link(http2https($url))) {
            print STDERR "\033[2K\rSEC $url\n";
            $url = http2https($url);
        } else {
            print STDERR "\033[2K\rUNS $url\n";
        }
    }
    "$url$delimiter";
#eg;
