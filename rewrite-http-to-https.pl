#!/usr/bin/perl -i -pw
# Simple script to substitute HTTP links by HTTPS links in text files.
# Curl is used to check whether the potential HTTPS alternatives work.
#
# Usage: perl -i -pw rewrite-http-to-https.pl text1.txt text2.txt ...
#
# Or in parallel: for i in *.txt; do perl -i -pw rewrite-http-to-https.pl "$i" & sleep 0.1; done

sub check_link {
    system(qw< curl -L -m 30 -f -o /dev/null -s -- >, $_[0]) == 0;
}

sub http2https {
    my $str = shift;
    $str =~ s#^http://#https://#;
    return $str;
}

next if /xmlns|\Q192.168.\E|\Qfd00:\E|localhost/;

s|(http://.*?)([\s\)\]}"<>])|
    my $url       = $1;
    my $delimiter = $2;

    if($url =~ /\Qwww.w3.org/) {  # is contained in XML headers
        print STDERR "IGN $url\n";
    } else {
        print STDERR "... $url";
        if(not check_link($url)) {
            print STDERR "\033[2K\r404 $url\n";
        } else {
            if(check_link(http2https($url))) {
                print STDERR "\033[2K\rSEC $url\n";
                $url = http2https($url);
            } else {
                print STDERR "\033[2K\rUNS $url\n";
            }
        }
    }

    "$url$delimiter";
|eg;
