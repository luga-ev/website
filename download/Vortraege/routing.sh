#!/bin/sh

case $1 in
    start)
        echo "Setting up forwarding and NAT..." >&2
        echo 1 > /proc/sys/net/ipv4/ip_forward
        iptables -F
        iptables -F -t nat
        iptables -A FORWARD -j ACCEPT
        iptables -t nat -A POSTROUTING -j MASQUERADE
        ;;

    redirect-http)
        echo "Redirecting HTTP traffic to $2:$3..." >&2
        iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 80 -j REDIRECT --to-port $3 -d $2
        ;;

    stop)
        echo "Bringing forwarding and NAT down..." >&2
        echo 0 > /proc/sys/net/ipv4/ip_forward
        iptables -F
        iptables -F -t nat
        ;;

    *)
	echo "Usage: $0 start|redirect-http|stop" >&2
	exit 1
	;;
esac
