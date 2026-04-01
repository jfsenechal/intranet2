#!/bin/bash
php artisan config:clear --silent
php artisan optimize:clear --silent
php artisan filament:optimize-clear --silent
rm -f storage/logs/*.log
rm -rf bootstrap/cache/blade-icons.php bootstrap/cache/filament/ bootstrap/cache/packages.php bootstrap/cache/services.php
rm -fr storage/framework/views/*.php
