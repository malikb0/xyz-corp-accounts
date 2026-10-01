# docker/

Container configuration for the application.

| File | Purpose |
|---|---|
| `apache-vhost.conf` | Apache virtual host (document root `/var/www/html`, `AllowOverride All`) |
| `php.ini` | PHP overrides (development error display, upload/memory limits) |
| `entrypoint.sh` | Ensures `application/cache` and `application/logs` are writable, then starts Apache |

See `../Dockerfile` and `../docker-compose.yml`, and
[../docs/DEPLOYMENT.md](../docs/DEPLOYMENT.md).
