#!/bin/sh
set -e

# Lance les migrations automatiquement au demarrage
# Lance les migrations automatiquement au demarrage
php artisan migrate --force

# Cree les roles et le compte admin (sans risque de doublon grace a firstOrCreate)
php artisan db:seed --force
# Cree le lien symbolique de stockage (photos joueurs, etc.)
php artisan storage:link || true

# Optimise Laravel pour la prod
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Demarre PHP-FPM en arriere-plan
php-fpm -D

# Demarre Nginx au premier plan (garde le container actif)
nginx -g "daemon off;"