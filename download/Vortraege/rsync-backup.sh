#!/bin/bash

### Konfiguration
# Verzeichnis, in dem die Backups abgelegt werden sollen.
BASE=/tmp/data/backups

# Optionen, die an rsync übergeben werden sollen -- zum Ausschluss von Dateien,
# die nicht gesichert werden sollen.
RSYNC_OPTS="--exclude=.gvfs --exclude=.thumbnails --exclude=Cache/ --exclude=.cache/"

# Kurzname für die Backups.
PROFILE=home

# Verzeichnis, das gesichert werden soll.
SOURCE="/tmp/testdir"
### Ende der Konfiguration


DATE="`date +%Y-%m-%d-%H-%M`"
PREV="`find "$BASE" -maxdepth 1 -name "$PROFILE--*" | grep -v \\.log | sort -n | tail -n 1`"
LOG="$BASE/wip--$PROFILE--$DATE.log"

[ -d "$BASE" ] || {
  echo "Verzeichnis, in dem das Backup angelegt werden soll, existiert nicht." >&2
  exit 1
}

[ -e "$BASE/$PROFILE--$DATE" ] && {
  echo "Backup mit dem gleichen Zeitstempel $DATE existiert bereits." >&2
  exit 1
}

cat <<EOF > "$LOG"
Backup of $PROFILE at `date`

rsync options: $RSYNC_OPTS
previous backup: $PREV

EOF

if [ -n "$PREV" ]; then
  rsync --delete -avz --link-dest="$PREV" $RSYNC_OPTS "$SOURCE" "$BASE/wip--$PROFILE--$DATE" 2>&1 | \
    tee -a "$LOG"
else
  rsync --delete -avz $RSYNC_OPTS "$SOURCE" "$BASE/wip--$PROFILE--$DATE" 2>&1 | \
    tee -a "$LOG"
fi

echo >> "$LOG"
echo "rsync finish: `date`" >> "$LOG"
echo "disk usage: `du -m --max-depth=0 "$BASE/wip--$PROFILE--$DATE" | awk '{ print $1 }'`" >> "$LOG"
df -h "$BASE/wip--$PROFILE--$DATE" >> "$LOG"

mv "$BASE/wip--$PROFILE--$DATE" "$BASE/$PROFILE--$DATE"
mv "$LOG" "$BASE/$PROFILE--$DATE.log"
