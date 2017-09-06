#!/usr/bin/perl

use warnings;
use strict;

print "Gib deinen Namen ein: ";
my $name = <STDIN>; # Name einlesen
chomp $name;        # "\n" entfernen

print "Gib dein Alter ein: ";
# Name einlesen und zugleich "\n" entfernen
chomp(my $alter = <STDIN>);
# my $alter = chomp(<STDIN>) ist FALSCH!!!

print "Hallo $name, in 10 Jahren bist du "
      . ($alter+10) . ".\n";
