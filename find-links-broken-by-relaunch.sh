#!/bin/bash

# Annahmen des Skripts:
# * Eine Kopie der alten LUGA-Seite befindet sich in $1.
# * Die neue Seite ist auf http://luga-dummy/ erreichbar.

# Ausgabe des Skripts:
# * Redirect-Direktiven für Apache für verschobene Inhalte
# * Traurige Smileys für nicht wiedergefundende Inhalte

cd -- "$1"
find . | while read; do
    curl -sf http://luga-dummy/"$REPLY" >/dev/null || echo "$REPLY"
done | egrep -v "/LUGA_Logo|corner_tr|/onepixel|/corner_top|/line_t|/edge_top|/corner_bl|/Pinguin|/corner_tl|/corner_br" | while read; do
    REPLY="${REPLY:2}"
    REPLY="${REPLY%.1}"  # von wget ergänzte Suffixe
    REPLY="${REPLY%.2}"
    basename="$(basename "$REPLY")"
    ohneindexhtml="${REPLY%index.html}"

    if curl -sf http://luga-dummy/download/Vortraege/"$basename" >/dev/null; then
        echo "Redirect permanent /$REPLY https://www.luga.de/download/$basename"
    elif curl -sf http://luga-dummy/"$REPLY"/ >/dev/null; then
        echo "Redirect permanent /$REPLY https://www.luga.de/$REPLY/"
    elif curl -sf http://luga-dummy/"$ohneindexhtml" >/dev/null; then
        echo "Redirect permanent /$REPLY https://www.luga.de/$ohneindexhtml"
    else
        echo "# :-( $REPLY"
    fi
done
