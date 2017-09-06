#!/usr/bin/perl

use warnings;
use strict;

use IO::Socket::INET;
use Getopt::Long;

# Nice debugging output.
{
  my $fresh;
  sub debug($) {
    my $msg = shift;

    print STDERR "> " and $fresh++ unless $fresh;
    print STDERR $msg;
    $fresh = 0 if substr($msg, -1) eq "\n";
    1;
  }
}

# ARGV parsing.
my $PORT;
my $PEER;
my $WINDOW = 10;
my $CMD;
GetOptions(
  "port=i"   => \$PORT,
  "peer=s"   => \$PEER,
  "window=i" => \$WINDOW,
  "cmd=s"    => \$CMD,
  "help"     => \&usage,
) or usage();
usage() unless defined $PEER and defined $PORT;

# Turning on autoflusj on STDIN and STDOUT.
autoflush(\*STDOUT);
autoflush(\*STDIN);

# Helper sub to create our socket...
sub sockgen {
  debug "Creating socket localhost:$PORT <-> $PEER:$PORT... ";
  my $sock = IO::Socket::INET->new(
    PeerHost  => $PEER,
    PeerPort  => $PORT,
    LocalPort => $PORT,
    Proto     => "udp",
    ReuseAddr => 1,
  ) or die "Couldn't create socket: $!\n";
  debug "done.\n";

  # ...with autoflush turned on.
  autoflush($sock);
  return $sock;
}

# Helper sub to wait for a given char.
sub waitfor {
  my ($sock, $match) = @_;

  while(1) {
    debug ".";
    my $char = getc $sock;
    last if defined $char and $char eq $match;
  }
}

# Initial phase: Sending of initial packets to make the firewalls think the
# packets are replies.
my $sock = sockgen();
debug "Sending $WINDOW initial packets... ";
for(1..$WINDOW) {
  debug ".";
  print $sock ".";
  sleep 1;
}
print $sock "!";
debug " done.\n";

# Waiting for ACK packet so we see the connection is established.
debug "Waiting for ACK... ";
waitfor($sock, "!");
debug " done.\n";

# To work around several quirks.
debug "Closing inital socket... ";
close $sock or die "Couldn't close socket: $!\n";
debug "done.\n";
$sock = sockgen();

# :)
debug "Connection established.\n";

# Either exec() $CMD or relay STDIN and STDOUT appropriately.
if(defined $CMD) {
  debug "Redirecting STDIN and STDOUT... ";
  open STDOUT, ">&", $sock or die "Couldn't redirect STDOUT: $!\n";
  open STDIN,  "<&", $sock or die "Couldn't redirect STDIN: $!\n";
  debug "done.\n";
  debug "exec()ing \"$CMD\"...\n";
  exec $CMD or die "Couldn't exec() \"$CMD\": $!\n";
} else {
  debug "Type ahead.\n";
  $SIG{CHLD} = "IGNORE";
  my $pid = fork;
  die "Couldn't fork: $!\n" unless defined $pid;

  if($pid) {
    # Parent -- read chars from STDIN and send them to the socket.
    while(defined(my $char = getc STDIN)) {
      print $sock $char;
    }

    # Exit on ^D.
    debug "Exiting; sending SIGTERM to child process... ";
    kill 15 => $pid or die "Couldn't send SIGTERM to child process (PID $pid): $!\n";
    debug "done.\n";

  } else {
    # Child -- print what's "in the socket".
    print $_ while defined($_ = getc $sock);
  }

  # Clean up after ourselves.
  close $sock or die "Couldn't close socket: $!\n";
}

# Helper sub to turn autoflush on a filehandle on.
sub autoflush {
  my $fh = shift;

  my $old_fh = select $fh;
  $|++;
  select $old_fh;
}

# Display usage info.
sub usage { print STDERR <<USAGE; exit }
nat-udp.pl -- Establish an UDP connection between two hosts which are behind
              NAT gateways.

Usage: $0 options

Available options:
  --port=43200         The port to use.
  --peer=other-host    The peer to contact.
  --window=10          The number of initial packets to send.
  --cmd="pppd..."      The command to run with its STDIN and STDOUT
                       being the socket.
                       If none is specified, everything you type is
                       relayed to the other end of the socket, and vice versa.
  --help               This help.

Options may be abbreviated to uniqueness.
USAGE
