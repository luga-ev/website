#!/usr/bin/perl

use warnings;
use strict;

chomp(my $faktor1 = <STDIN>);
chomp(my $faktor2 = <STDIN>);

print abs($faktor1*$faktor2) . "\n";
