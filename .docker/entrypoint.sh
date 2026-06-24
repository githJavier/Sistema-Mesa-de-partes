#!/bin/bash
set -e

# En Railway el volumen montado puede reintroducir varios MPM en runtime.
# Por eso forzamos un único MPM (prefork) en cada arranque, no en el build.
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true
a2dismod mpm_prefork 2>/dev/null || true
a2enmod mpm_prefork

exec apache2-foreground
