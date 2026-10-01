# Structure

![Directory structure](assets/structure.svg)

## Directory tree

```
xyz-corp-accounts/
├── index.php                     # CodeIgniter front controller
├── system/                       # CodeIgniter 3.1.13 framework core
├── application/                  # application code (MVC)
│   ├── config/                   # environment-driven configuration
│   ├── controllers/              # 25 controllers (modules + auth)
│   ├── core/                     # (empty) custom core classes
│   ├── helpers/                  # (empty) helper extensions
│   ├── hooks/                    # (empty)
│   ├── language/english/         # language strings
│   ├── libraries/                # GroceryCRUD, image_moo
│   ├── logs/, cache/             # runtime (ignored)
│   ├── models/                   # CRUD/query models
│   ├── third_party/              # (empty)
│   └── views/                    # layouts, screens, reports, I18N
├── assets/
│   ├── css/                      # project stylesheet
│   ├── grocery_crud/             # Grocery CRUD 1.6.4 assets + themes
│   ├── jquery_ui/                # jQuery UI
│   ├── print_jq/                 # printThis plugin
│   └── uploads/files/            # runtime upload targets (ignored)
├── admin_resources/              # SB Admin 2 admin theme + jQuery 3.5.1
├── imgs/                         # web-root images (logo)
├── resources/                    # misc web-root assets
├── db/
│   ├── init/                     # 01-schema.sql, 02-seed.sql (Docker init)
│   └── private/                  # local DB dumps (git-ignored)
├── docker/                       # apache-vhost.conf, php.ini, entrypoint.sh
├── docs/                         # this documentation (+ diagrams, assets)
├── scripts/                      # smoke-test.sh, gen-catalog.sh
├── licenses/                     # third-party licence texts
├── Dockerfile
├── docker-compose.yml
├── Makefile
├── .editorconfig
├── .env.example
├── README.md
├── LICENSE                       # study-only source licence
├── NOTICE                        # copyright + third-party attribution
├── SECURITY.md                   # security policy (study copy)
├── CHANGELOG.md                  # summary changelog
├── CONTRIBUTING.md
├── CODE_OF_CONDUCT.md
└── xyz_corp_db.sql               # schema dump (copied into db/init/01-schema.sql)
```

## Where things live

| Concern | Location |
|---|---|
| Routes | `application/config/routes.php` |
| DB settings | `application/config/database.php` (env-driven) |
| App settings | `application/config/config.php` (env-driven) |
| Mail settings | `application/config/email.php` (env-driven) |
| Auth logic | `application/controllers/User_Authentication.php`, `application/models/Login_database.php` |
| Admin layout | `application/views/admin-{head,js,nav,page,notifications}.php`, `display-panel.php` |
| CRUD library | `application/libraries/Grocery_CRUD.php` |
| CRUD assets/themes | `assets/grocery_crud/` |
| Admin theme | `admin_resources/` |
| Schema/seed | `db/init/` |

See [`FILE_CATALOG.md`](FILE_CATALOG.md) for the full file inventory.
