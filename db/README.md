# db/

Database assets.

| Path | Contents |
|---|---|
| `init/` | SQL executed automatically by the MySQL container on first boot — see [init/README](init/README.md) |
| `private/` | For your own local database dumps (git-ignored). Used by `make load-backup`. |

No client or financial data is included in this repository. `db/private/backup.sql`
is the expected filename for a local restore.
