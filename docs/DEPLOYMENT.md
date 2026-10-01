# Deployment

![Deployment](assets/deployment.svg)

## Local / single-host (Docker Compose)

```bash
cp .env.example .env      # set APP_BASE_URL, passwords, etc.
docker compose up -d --build
```

| Service | Image | Host port | Notes |
|---|---|---|---|
| `app` | built from `Dockerfile` (`php:7.4-apache`) | `8080` | Apache document root `/var/www/html`; source bind-mounted from the repo |
| `db` | `mysql:5.7` | `3307` | Schema + seed loaded from `db/init/` on first boot |
| `phpmyadmin` | `phpmyadmin:5` | `8081` | Connected to `db` |

Data lives in the named volume `db_data`; the application source is bind-mounted
so edits are picked up without a rebuild (`make restart` reloads Apache).

## Configuration

`.env` is the single source of configuration (git-ignored). `.env.example`
documents every variable. Nothing is hard-coded in the application.

## Ports

Change the host-side ports in `docker-compose.yml` (`8080`, `8081`, `3307`) or
put a reverse proxy (nginx/Caddy/Traefik) in front of `app:80` and terminate TLS
there. Set `APP_BASE_URL` to the public URL so asset links resolve correctly.

## Database backup & restore

- **Back up:**
  ```bash
  docker compose exec -T db mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" xyz_corp_db > backup.sql
  ```
- **Restore your own dump:** put it at `db/private/backup.sql` and
  ```bash
  make load-backup
  ```
  `db/private/` is git-ignored, so a restored dump never enters version control.

## Production caveats

- **PHP 7.4 and MySQL 5.7 are end-of-life.** This stack is intentionally pinned
  to reproduce a 2016–2022 application. For anything internet-facing, put it
  behind authentication, keep it off the public internet, and plan an upgrade.
- The container runs Apache with `display_errors` on (development). For a
  hardened run, set `CI_ENV=production` and turn `display_errors` off in
  `docker/php.ini`.
- Sessions use the files driver in `/tmp`; on multiple replicas, point
  `APP_SESS_SAVE_PATH` at shared storage or switch to a database/redis driver.

## Rebuilding the image

The image installs PHP extensions from Debian bullseye, which is archived. The
`Dockerfile` pins apt to the frozen `snapshot.debian.org` archive the base image
references, so builds stay reproducible.
