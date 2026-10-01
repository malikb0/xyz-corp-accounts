# Testing

There is no automated test suite in the original application; the checks below
verify that the stack boots, the schema loads, authentication works and every
module renders. The smoke test is the fastest end-to-end gate.

## Smoke test

```bash
make up          # start the stack
make smoke       # login + request every module
```

`scripts/smoke-test.sh` logs in as the seeded `admin` user, then requests every
controller and fails if any returns a non-200 status or emits a PHP
error/exception. Expected tail:

```
Login
  ok    login (dashboard reached)
Modules
  ok    Welcome
  ok    Accounts
  ...
SMOKE TEST PASSED
```

Override credentials/target with environment variables:

```bash
SMOKE_USER=accountant SMOKE_PASS=accountant123 BASE_URL=http://localhost:8080 make smoke
```

## What the smoke test covers

| Check | How |
|---|---|
| Stack boots | `docker compose up` reaches healthy `db`, `app` |
| Schema + seed load | `db/init/01-schema.sql`, `02-seed.sql` on first boot |
| Authentication | POST to `User_Authentication/user_login_process`, dashboard marker |
| Modules render | GET each controller; assert no `PHP Error` / `uncaught Exception` |

Not covered automatically: browser-side JavaScript behaviour and the actual
POST/print flows of invoices and reports. Exercise those manually.

## Manual checklist

1. `make up`, open <http://localhost:8080>.
2. Log in with `admin` / `admin123` — the dashboard shows account totals.
3. Open a CRUD module (e.g. **Accounts**) — list/add/edit pages render with the
   Bootstrap theme.
4. Create a row, edit it, delete it.
5. Open a report (**Get reports**) and an invoice screen; use the print action.
6. Log out.

## Database checks

```bash
# count tables
make db
mysql> SHOW TABLES;                     -- expect 18 tables
mysql> SELECT sf_name, role FROM tb_sf_login;   -- role is informational only here
```

## Reproducing from a clean state

```bash
make reset        # down -v && up --build : empties the volume and re-seeds
make smoke
```
