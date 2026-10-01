# application/config/

CodeIgniter configuration. Environment-specific values are read with `getenv()`
so no secrets live in the repository (see `../.env.example`).

| File | Purpose |
|---|---|
| `config.php` | App settings; `base_url`, `encryption_key`, `sess_save_path` from env |
| `database.php` | Database connection groups; all credentials from `DB_*` env vars |
| `email.php` | SMTP settings from `MAIL_*` env vars |
| `autoload.php` | Autoloaded libraries/helpers |
| `routes.php` | URI routing (`default_controller = welcome`) |
| `constants.php` | App constants |
| `hooks.php`, `migration.php`, `profiler.php`, `memcached.php` | Framework settings |
| `doctypes.php`, `foreign_chars.php`, `mimes.php`, `smileys.php`, `user_agents.php` | Framework data tables |
| `grocery_crud.php` | Grocery CRUD defaults |

> Do not hard-code hosts or credentials here. Add new variables to
> `../.env.example` and read them with `getenv()`.
