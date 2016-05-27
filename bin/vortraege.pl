#!/usr/bin/perl
# Packt die Vorträge in eine neue Struktur
use strict;
use warnings;
use Encode qw(decode encode);

chdir '/home/michael/Antares/Projekte/luga/Angebote/Vortraege';
my @files;
my @register;

@files = `ls`;

while(<@files>)	{
	if( -f $_ )	{
		if(substr($_, 0, 10)  ne 'index.html')	{
			push @register, mark_down($_);
		}
	}
	elsif( -d $_ )	{
		# Alle Inhalte des Verzeichnisses in /home/michael/Antares/html/luga/html/download kopieren
		`cp $_/* /home/michael/Antares/html/luga/html/download`;
	}
}	

@register = uniq(@register);
@register = reverse sort(@register);
print @register;

open(MENU, ">/home/michael/Antares/html/luga/menu/vortraege.csv") or die ("vortraege.csv nicht geöffnet\n");
print MENU "#Register der Vorträge;\n";
print MENU "#Neueste Vorträge bitte oben einfügen;\n";
print MENU "#datum YYYY-MM-DD|Titel|Referent|Dateiname\n"; 
print MENU @register;
close MENU;


# Erwargtet Dateiname als Parameter
sub mark_down()	{
	my $file = $_[0];
	my $flag;
	my $md;
	my $datum;
	my $flag_datum = 0;
	my $titel;
	my $flag_titel = 0;
	my $referent;
	my $flag_referent = 0;
	my @dz;
	my $outfilename;
	

	open(EIN, "$file");
	$flag = 0;

	while(<EIN>)	{
		$_ =~ s/\r//g;

		if( $_ =~ /end Desktop/ )	{ $flag = 0; }

		if ( $flag == 1) { $md .= $_; }
		
		if( $_ =~ /<div id="Desktop">/ )	{
			$flag = 1;
		}

		# Datum heraus holen
		if( $flag_datum == 2 )	{
			$datum = $_;
			$datum =~ s/ //g; 
			$datum =~ s/\n//g;
			
			#Datum nach iso wandeln
			@dz = split /\./, $datum;
			$datum = $dz[2] . '-' . $dz[1] . '-' . $dz[0];
			
			$flag_datum = 0;
		}

		if( $flag_datum == 1 )	{
			$flag_datum++;
		}
		
		if( $_ =~ /<b>Datum<\/b>/ )	{
			$flag_datum = 1;
		}

		# Titel heraus holen
		if( $flag_titel == 2 )	{
			$titel = $_;
			$titel =~ s/^ +//g; 
			$titel =~ s/\n//g;
			
			$flag_titel = 0;
		}

		if( $flag_titel == 1 )	{
			$flag_titel++;
		}
		
		if( $_ =~ /<b>Titel<\/b>/ )	{
			$flag_titel = 1;
		}

		# Referent heraus holen
		if( $flag_referent == 2 )	{
			$referent = $_;
			$referent =~ s/^ +//g; 
			$referent =~ s/\n//g;
			$referent =~ s/<a.+>//g;
			$referent =~ s/<\/a>//g;
			
			$flag_referent = 0;
		}

		if( $flag_referent == 1 )	{
			$flag_referent++;
		}
		
		if( $_ =~ /<b>Referent\(en\)<\/b>/ )	{
			$flag_referent = 1;
		}
		
	}

	#md manipulieren
	$md =~ s/<div>//g;
	$md =~ s/<\/div>//g;
	$md =~ s/ *<p class="indent".*>\n/> /g;
	$md =~ s/ *<p><b>Titel<\/b><\/p>.*\n>  (.+?)\n<\/p>/##$1/g;

	$md =~ s/<a href="(.+?)">(.+?)<\/a>/[$2](\/download\/$1)/g;
	$md =~ s/<p><b>Referent\(en\)<\/b><\/p>/### Referent(en)/g;
	$md =~ s/ *<p><b>Datum<\/b><\/p>/### Datum/g;
	$md =~ s/<p><b>(Kurzbeschreibung)<\/b><\/p>/### Kurzbeschreibung/g;
	$md =~ s/ *<p><b>Manuskript<\/b><\/p>/### Manuskript/g;
	$md =~ s/ *<p>//g;
	$md =~ s/ *<\/p>\n//g;
	$md =~ s/<ul>\n//g;
	$md =~ s/<\/ul>\n//g;
	$md =~ s/ *<li>\n/* /g;
	$md =~ s/<\/li>\n//g;
	$md = encode("utf8", $md, 1);
	#$md =~ s/\n+/\n/g;

	$referent = encode("utf8", $referent, 1);
	$titel    = encode("utf8", $titel, 1);
	close EIN;
	
	
	$outfilename = $file;
	$outfilename =~ s/\..*//g;
	$outfilename =~ s/\?.*//g;
		
#	print "$datum|$titel|$referent|>/home/michael/Antares/html/luga/md/$file\n";
	open(AUS, ">/home/michael/Antares/html/luga/md/vortraege/$outfilename.txt") or die("Konnte datei $outfilename nicht öffnen");
	print AUS $md;
	close AUS;

	#print $md;
	return "$datum|$titel|$referent|$outfilename\n";
}

# Helper function to remove duplicates in a list.
sub uniq {
  my %seen;
  grep !$seen{$_}++, @_;
}

#cp: der Aufruf von stat für »Debian_Jessie_ohne_systemd_LIT_2015/*“ ist nicht möglich: Datei oder Verzeichnis nicht gefunden
#cp: der Aufruf von stat für »GIMP_LIT_2009/*“ ist nicht möglich: Datei oder Verzeichnis nicht gefunden
#cp: der Aufruf von stat für »IPython_Notebook_LIT_2015/*“ ist nicht möglich: Datei oder Verzeichnis nicht gefunden
#cp: der Aufruf von stat für »NixOS_LIT_2015/*“ ist nicht möglich: Datei oder Verzeichnis nicht gefunden
#cp: der Aufruf von stat für »Virtual_Box_LIT_2010/*“ ist nicht möglich: Datei oder Verzeichnis nicht gefunden

