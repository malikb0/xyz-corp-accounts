# application/

The CodeIgniter application (MVC) for `xyz-corp-accounts`.

| Path | Contents |
|---|---|
| `config/` | Environment-driven configuration (routes, DB, app, mail) — see [config/README](config/README.md) |
| `controllers/` | 25 controllers, one per module + auth — see [controllers/README](controllers/README.md) |
| `models/` | Grocery CRUD and query models — see [models/README](models/README.md) |
| `views/` | Layouts, screens, reports, Arabic I18N — see [views/README](views/README.md) |
| `libraries/` | Grocery CRUD and image_moo — see [libraries/README](libraries/README.md) |
| `language/english/` | Language strings |
| `core/`, `helpers/`, `hooks/`, `third_party/` | Reserved by CodeIgniter; currently empty |
| `cache/`, `logs/` | Runtime directories (git-ignored) |
| `.htaccess` | Denies direct web access to this folder |
| `index.html` | Directory-listing guard |

See [../docs/ARCHITECTURE.md](../docs/ARCHITECTURE.md) for how these fit together.
