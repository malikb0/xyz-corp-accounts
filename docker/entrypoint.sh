#!/bin/bash
set -e

# CodeIgniter writes sessions/cache/logs at runtime; make sure the
# container user can write to them even when the tree is bind-mounted.
mkdir -p /var/www/html/application/cache /var/www/html/application/logs
chmod -R 777 /var/www/html/application/cache /var/www/html/application/logs 2>/dev/null || true

exec "$@"
