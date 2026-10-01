# db/init/

SQL run by the `mysql:5.7` container, in filename order, the first time the data
volume is created.

| File | Contents |
|---|---|
| `01-schema.sql` | 18 tables (derived from the original dump, with the database name neutralised) |
| `02-seed.sql` | Synthetic test data: 7 login users (one per role + two assistants), 2 accounts |

Login users created by the seed:

| User | Password | Role |
|---|---|---|
| `admin` | `admin123` | admin |
| `accountant` | `accountant123` | standard |
| `addoper` | `add123` | addoper |
| `owner` | `owner123` | ronlyowner |
| `hruser` | `hr123` | hronly |
| `asst1` | `asst1123` | account_assistant |
| `asst2` | `asst2123` | account_assistant |

This working copy uses a **single authentication layer** — the `role` column is
retained for reference but is no longer enforced (see
[../../docs/AUTHENTICATION.md](../../docs/AUTHENTICATION.md)).

To start over, run `make reset` (removes the volume and re-runs both files).
See [../../docs/DATABASE.md](../../docs/DATABASE.md) for the schema and ERD.
