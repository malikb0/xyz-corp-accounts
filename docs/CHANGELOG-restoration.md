# Restoration & change log

Every change made to this copy, with the reason. The starting point was a partial
copy containing only `application/` plus a schema dump; it was made runnable,
de-branded, documented, and reduced to a single authentication layer —
**without changing the application's business logic**. A byte-for-byte snapshot
of the copy as received is kept outside the repository
(`xyz-corp-accounts.pristine-YYYYMMDD.tar.gz`).

---

## 1. Added (the copy was missing these)

| Item | Source | Reason |
|---|---|---|
| `system/`, `index.php` | CodeIgniter 3.1.13 | Framework core was absent — the app could not bootstrap |
| `assets/grocery_crud/` | Grocery CRUD 1.6.4 | CRUD screens failed without the library's assets/languages |
| `assets/grocery_crud/themes/bootstrap/` | Grocery CRUD bootstrap theme | 11 controllers call `set_theme('bootstrap')` |
| `admin_resources/` | Start Bootstrap SB Admin 2 (Bootstrap 3) v3.3.7+1 | Admin theme was not in the copy |
| `admin_resources/vendor/jquery/jquery-3.5.1.min.js` | jQuery 3.5.1 | Referenced by `admin-js.php` |
| `assets/jquery_ui/` | jQuery UI 1.12.1 | Referenced by the views |
| `assets/print_jq/printThis.js` | printThis 1.15.0 | Referenced by the views |
| `assets/uploads/files/*` (18 dirs) | created empty | `set_field_upload(...)` requires the target folders |
| `imgs/logo.jpg`, `assets/css/general-common-custom.css`, `resources/style.css` | placeholders | Referenced web-root assets not in the copy |
| `licenses/CodeIgniter-MIT.txt` | CodeIgniter | Framework licence text |
| Docker stack (`Dockerfile`, `docker-compose.yml`, `docker/`) | authored | One-command local runtime |
| `db/init/01-schema.sql`, `db/init/02-seed.sql` | derived from the dump | Bootstrappable schema + synthetic test data |
| `Makefile`, `scripts/smoke-test.sh` | authored | Run/test ergonomics |
| `scripts/gen-catalog.sh` | authored | Documentation tooling |
| `.env.example`, `.dockerignore`, `.gitignore`, `.gitattributes` | authored | Reproducible, clean repo |
| `docs/` | authored | Full documentation (see §7) |

## 2. Changed (credentials, hosts, safe fixes)

| Change | File(s) |
|---|---|
| DB credentials → `DB_*` env vars; connection groups preserved | `application/config/database.php` |
| SMTP credentials → `MAIL_*` env vars | `application/config/email.php` |
| `base_url`, `encryption_key`, `sess_save_path` → env vars | `application/config/config.php` |
| `CI_ENV` read via `getenv()` | `index.php` |
| ~16 hard-coded production URLs → `base_url()` / `site_url()` | `controllers/{Data_reports,Get_report}.php`, several views |
| Client identifiers (domain, e-mail addresses, logo filename) → placeholders | several views |
| `sleep(20)` removed from the login handler | `application/controllers/User_Authentication.php` |
| Registration password hashed (`md5`) to match login | `application/controllers/User_Authentication.php` |
| Session id regenerated on successful login | `application/controllers/User_Authentication.php` |
| `sess_save_path` default `/tmp` (was `NULL` → `mkdir(): Invalid path`) | `application/config/config.php` |

## 3. Removed

| Item | Count | Reason |
|---|---:|---|
| Windows `*:Zone.Identifier` alternate-stream files | 408 | Junk created by unzipping on Windows |
| Commented `MAwaisR` username check | 1 | Removed with the authorization layer (see §6) |
| Duplicate case-variant `application/libraries/grocery_CRUD.php` | 1 | Identical to `Grocery_CRUD.php`; a case-only path breaks Windows/macOS and case-insensitive drives |

## 4. De-branding (→ “XYZ Corp”)

| From | To | Where |
|---|---|---|
| Original client's company name | `XYZ Corp` / `XYZ CORP` | invoice/VAT/report/salary views |
| Client-specific database name | `xyz_corp_db` | schema dump, `db/init`, `.env`, compose, docs |
| Client-specific DB credentials | `xyz_user` / `xyz_password` | `.env`, compose, `database.php` default |
| Client-specific schema dump filename | `xyz_corp_db.sql` | repo root |
| Original app slug | `xyz-corp-accounts` | README/docs/Makefile/compose project name |
| Client-specific element id | `co_logo` | report/salary/data views |
| Original repository directory | `xyz-corp-accounts` | `~/projects/` |

The legacy, client-specific connection-group names were generalised to neutral
ones (`appuser` / `readonly` / `acctmgr` / `appadmin`), and the seed usernames
now read `asst1` / `asst2`.

**Left intact (bound to existing data):** table `tb_sf_login` and columns
`sf_id/sf_name/sf_email/sf_password` (opaque legacy prefixes) — see
[AUTHENTICATION](AUTHENTICATION.md).

## 5. Repository & version control

| Action | Detail |
|---|---|
| Initialised git | `git init`; branch `master` |
| `.gitattributes` | normalise our text files; **`-text` for vendored trees** (`system/`, `assets/grocery_crud/`, `admin_resources/`, `application/views/I18N/`) to avoid churning/mangling third-party bundles |
| `.gitignore` | ignores `.env`, `db/private/`, runtime caches/logs, uploaded files (folders kept via `index.html`), OS junk |
| History | rewritten (orphan) into a **single de-branded root commit**; old branded commits and blobs purged with `git gc` |
| Never pushed | no remote added — the owner pushes |

## 6. Authentication (authorization removed)

Inline, name-based checks were first replaced with a central role/permission
(RBAC) layer, and that layer was then **removed for simplicity** — this working
copy now keeps a **single authentication layer** only:

- Login validates against `tb_sf_login`; the session id is regenerated on success
  and destroyed on logout.
- Every controller checks `isset($this->session->userdata['logged_in'])` and shows
  the login form when absent.
- The earlier RBAC policy/engine (`can()`, `is()`, `check()`, `apply_crud()`),
  per-role row-level scoping and menu gating are gone; the `role` column remains
  in `tb_sf_login` but is not enforced.

Details: [AUTHENTICATION](AUTHENTICATION.md).

## 7. Documentation & tooling

| Added | Purpose |
|---|---|
| `README.md` | Overview, quick start, project layout, notable fixes |
| `docs/README.md` | Documentation hub + rendered diagrams |
| `docs/ARCHITECTURE.md` | Request flow, auth, multi-tenant DB, assets |
| `docs/MODULES.md` | Controller/model catalogue |
| `docs/DATABASE.md` | Tables + ERD |
| `docs/STRUCTURE.md`, `docs/FILE_CATALOG.md` | Tree + auto-generated inventory |
| `docs/TESTING.md`, `docs/DEPLOYMENT.md`, `docs/DEVELOPMENT.md` | Run / deploy / extend |
| `docs/SECURITY.md`, `docs/AUTHENTICATION.md` | Security posture; login-only access |
| `docs/THIRD-PARTY.md`, `licenses/`, `LICENSE` | Licences (proprietary app, open-source deps) |
| `docs/diagrams/*.mmd`, `docs/assets/*.svg` | 6 Mermaid sources + rendered SVG |
| `docs/assets/badges/*.svg` | 7 self-contained stack badges (no external URLs) |
| Per-directory `README.md` | `application/`, `assets/`, `db/`, `docker/`, `scripts/`, … |
| `scripts/gen-catalog.sh` | Regenerates the file catalog |

## 8. Runtime / Docker notes

- Base image `php:7.4-apache` (Debian bullseye, archived) — apt is pinned to the
  frozen `snapshot.debian.org` archive the base references, so builds stay
  reproducible; `mbstring` needs `libonig-dev`.
- `mysql:5.7` (`--sql-mode=""`, utf8) + `phpmyadmin:5`; DB seeded from `db/init/`.
- Ports: app `8080`, phpMyAdmin `8081`, MySQL `3307`. Project name
  `xyz-corp-accounts`.

## 9. Not changed on purpose

- **Business logic**, queries, view markup and routes are the original.
- **Legacy security practices** (MD5 storage, string-built login query, CSRF off)
  are preserved so existing data authenticates; see [SECURITY](SECURITY.md).
- `application/controllers/Vendors_multigrid-nill.php` — its filename contains a
  hyphen so CodeIgniter cannot route it (pre-existing quirk).

## 10. Commit log (this repository)

Key commits (run `git log --oneline` for the full history):

| Commit | Summary |
|---|---|
| `b16d6c2` | Accounts & operations system: restored, containerised, documented |
| `2a5fcf8` | Hard-coded authorization replaced with role/permission RBAC |
| `dd3bd0e` | Study-only licence, root standard files, full de-brand |
| (later) | Authorization layer removed for simplicity (authentication only) |

## 11. Verification performed

| Check | Command | Result |
|---|---|---|
| PHP syntax (app code) | `docker compose exec app php -l …` | all clean |
| End-to-end smoke | `make smoke` | PASSED |
| DB schema/seed | `make reset` → `SHOW TABLES` | 18 tables, seed users |
| Asset resolution | `curl` each referenced asset | HTTP 200 |
| Mermaid diagrams | `mmdc` render | 6 SVGs |
