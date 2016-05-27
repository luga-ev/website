#!/usr/bin/perl

use warnings;
use strict;
use diagnostics;

my $zinssatz = 0.05;
my $darlehen = 100;
my $jahre    = 5;

my $schulden =
    $darlehen * ($zinssatz+1)**$jahre;

print "Ihre Schulden nach $jahre Jahren:\n";
print "$schulden\n";
