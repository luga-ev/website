# Vortrag - Linux Container: Ein Einstieg

### 1. Begrüßung und kurzer Überblick über den Rest des Vortrages
  + Das ist kein Docker spezifischer Vortrag
  + Kein Docker HowTo
  + Genereller Überblick über was der Einsatzzweck von Containern ist
  + Kleiner Einblick in den historischen und technischen Hintergrund
### 2. Was ist ein Container?
  + Frei nach Wikipedia:
    > Linux Container ist ein Oberbegriff für die Implementierung von Virtualisierung auf Betriebssystemebene in Linux.
    > Derzeit existieren eine Reihe solcher Implementierungen, die alle auf den Virtualisierungs-, Isolierungs- und Ressourcenverwaltungsmechanismen des Linux-Kernels basieren.
  + Mit dem Satz ist eigentlich schon alles gesagt. Aber wir sehen uns die einzelnen Aspekte davon mal genauer an....
#### 2.1 Virtualisierung auf Betriebssystemebene
  + Ich kann einzelne Prozesse von anderen auf meinem System isolieren "containen"
  + Eine Anwendung in einem Container sieht andere Prozesse in dem Container und nur Resourcen, die im zugeteilt wurden und kann nicht ausbrechen
  + Host Linux kontrolliert die Ressourcen und sieht alle Prozesse
  + [ ps Demo ] Kommandos
      + `docker-compose -f ps-demo.yml up -d`
      + `docker-compose -f ps-demo.yml exec nginx sh`
      + `docker-compose -f ps-demo.yml exec apache sh`
      + In beiden Container-shells: `ps -a`
      + Auf dem Host `ps -aux | grep 'PID\|httpd\|nginx'`
      + Wenn man curl verwenden will `apk add --update curl`
#### 2.2 Technischer Hintergrund

  + Chroot _Wer hat schon mal Arch Installiert?_
    + Erlaubt es einen andern ordner als neues `/` zu setzten und von da aus Befehle aus zu führen
    + Nützlich um von einem Live-Image aus den bootloader wieder her zu stellen oder ein passwort neu zu setzen (oder Arch zu installieren)
    + Mit `debootstrap` könnte man sich zum Beispiel das Debian-Userland in Arch holen und ein bestimmtes Debian-spezifisches Paket installieren wenn Kernel Verzeichnisse wie `/run`, `/dev` und `/proc` gemounted sind
    + Noch KEINE isolierung der Prozesse im chroot jail von den anderen (PIDs, user, ...) 
    + [ DEMO ]
      + Kurz erwähnen, dass es `debootstrap` gibt und `ls` auf `new-root`
      + `sudo arch-chroot new-root` 
      + `source /etc/profile`
      + `apt install cowsay`
      + `cowsay "Hallo Linux-Infotag"` 
      + außerhalb noch: `sudo du -h -d 1 `
  + Namespaces:
    + API des Linux Kernel um virtuell System Ressourcen wie Netzwerk Interfaces, Mount points, UserIDs und weitere System Ressourcen zu erstellen
    + Diese Ressourcen können einzelnen Prozessen zugewiesen werden
    + Namespaces können auch für sich genommen verwendet werden. Network Namespaces können zum Beispiel sehr nützlich sein um auf seinem eigenen Rechner virtuelle Netzerk Interfaces zu erstellen und damit ein Netzwerk zu simulieren
    + Beispiel: WLAN-Interface in eigenen Namespace verschieben und nur bestimmten Anwendungen zugänglich machen
    + Coole Dinge mit Wireguard wie allen Traffic durch Wireguard routen
  + Control Groups
    + management von CPU Zyklen, Arbeitsspeicher oder Netzwerk Bandbreite für Gruppen von Prozessen
    + Prozesse können in ihrem Ressourcenverbrauch eingeschränkt werden
    + Auch seperat Nutzbar
    + cgroup für einen Prozess wie eine DB der viel Abeitsspeicher braucht, bekommt aber nur ein fixes Limit, damit für eine kritische Anwendung noch genug verfügbar ist
    => Zusammen erschaffen dieses Schnittstellen die Grundlage für ein Container System
#### 2.3 Container sind keine Viruellen Maschinen
  + Hauptunterschied: Im Container werden einzelne Userspace-Features virtualisiert. Der Kernel(space) bleibt aber der gleiche. Für die virtuelle Maschine werden physische Ressource simuliert, auf denen dann ein neuer Kernel läuft.
  + [Bild aus LXD doku]
  + Vorteil Container:
    - Effizienter
    - Einfacher zu managen
    - Modular
  + Nachteil Container:
    - Näher am Host System als eine Virtuelle Maschine -> Potentiell Sicherheitsrisiko
    - Alle Container müssen mit den Features des Host-Kernel auskommen
    - Hauptsächlich Linux (Nachteil? naja, vielleicht will ja jemand was mit BSD machen)
  + Vorteil VM: 
    - Egal welcher Kernel: Linux, BSD, NT, x64, x86
    - Stärkere Isolierung
    - Voller root zugiff in der Virtuellen Maschine
  + Nachteil VM:
    - Höherer Resosourcenverbrauch
    - Voller Kernel Boot, systemd, ...
    - Ganz oder gar nicht
### 3. Kurze Geschichte

  + Container sind an sich kein neues Konzept
  + 1979 - UNIX v7: `chroot` system call, später in BSD
  + 2000 - FreeBSD Jails (ganz coole Story)
  + 2001 - Linux Vserver ermöglicht erste virtualisierung auf Betrtriebssystemebene durch Kernel Patching
  + 2004 - Solaris Zones (ähnlich zu Jails aber mit erweiterten Features, vor allem mit ZFS)
  + 2007 - Control Groups in den Linux Kernel integriert aus einem Programm bei Google
  + 2008 - LXC: Linux Userspace tooling cgroups und namespaces
  + 2013 - Googles lmctfy und Docker -> Container werden einer großen Masse zugänglich 
    + Durch Docker: Entwicklerfreundliches Tooling, Standartisierung, Packaging durch Images, Docker Hub
    + Docker ist weit nicht die einzige Möglichkeit Container laufen zu lassen: **LXD**, garden runc, rocket, systemd nspawn...
    + Auch Technolgiewn wie flatpak und snappy sind container technologien
  + ... Standartisierung, Orchestration, ....  
### 4. Praktische Anwendung

  + Konsolidierung mehrerer Anwendungen mit kollidierenden Abhängigkeiten, Library Versionen z.B, auf einem System
  + Portable Development Environments. Gegen "Works on My Machine" weil alle die gleiche Version haben
  + Abkapselung unsicherer Prozesse von einander: DB und Webserver auf einem Server aber in verschiedenen Containern
  + Portabilität nicht nur von Anwendungen sondern von dem gesamten Runtime Environments besonders dank Docker
  + Virtualisierung komplexerer Infrastruktur auf einem Rechner
  + Ermöglicht weitreichende Orchestrierung auf großen Rechner-Clustern mit Failover und großer Skalierung durch Lösungen wie Kubernetes




## Quellen
- [Wikipedia: Linux Container](https://en.wikipedia.org/wiki/Linux_containers)
- [TechSnap Podcast Folge 345](http://www.jupiterbroadcasting.com/119986/namespaces-goto-jail-techsnap-345/) Inspiration und Weitere Links
- [TechSnap Podcast Folge 349](http://techsnap.systems/349) Network Namespaces und Links dazu
- [Archwiki Chroot](https://wiki.archlinux.org/index.php/Change_root)
- [Linux Manpage Namespaces](http://man7.org/linux/man-pages/man7/namespaces.7.html)
- [Admin Magazin: Practical Benefits of Network Namespaces](http://www.admin-magazine.com/Archive/2016/34/The-practical-benefits-of-network-namespaces)
- [Wireguard and Network Namespaces](https://www.wireguard.com/netns/)
- [RHEL Documentation zu cgroups](https://access.redhat.com/documentation/en-us/red_hat_enterprise_linux/6/html/resource_management_guide/ch01)
- [Cannonical LXD Whitepaper](https://pages.ubuntu.com/container-whitepaper.html)
- [Pivotal Container History](https://content.pivotal.io/infographics/moments-in-container-history)
- [Entstehungsgeschichte BSD Jails vom Autor Selbst](http://phk.freebsd.dk/sagas/jails.html) mit ein paar lustigen Anektdoten
