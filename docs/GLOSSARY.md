# Glossary

Terms used across this repository's documentation.

| Term | Meaning |
|---|---|
| **ACID** | Atomicity, Consistency, Isolation, Durability — the guarantees of a transactional database. |
| **Arabic (RTL) support** | The app is bilingual; views and the I18N library render right-to-left Arabic text. |
| **Authentication** | Verifying *who* a user is (login). This working copy keeps authentication only. |
| **Authorization** | Deciding *what* a logged-in user may do. An earlier RBAC layer was removed here for simplicity — see [AUTHENTICATION](AUTHENTICATION.md). |
| **CodeIgniter (CI3)** | The PHP MVC framework (v3.1.13) the application is built on. |
| **Connection group** | A named set of database credentials in `application/config/database.php`; a login's `db_user` selects one. |
| **Controller** | MVC layer that handles a request and coordinates models/views (`application/controllers/`). |
| **CRUD** | Create, Read, Update, Delete — the standard data-management operations. |
| **CSRF** | Cross-Site Request Forgery; protection is currently disabled in this legacy copy. |
| **`acnt_id`** | The account a user is linked to in `tb_sf_login`; used for scoping in the original design. |
| **`db_user`** | Column in `tb_sf_login` naming the connection group a user connects with. |
| **ERD** | Entity-Relationship Diagram — the database schema picture (`docs/assets/erd.svg`). |
| **Grocery CRUD** | The PHP library (v1.6.4) that generates the admin CRUD screens. |
| **MD5** | A legacy, now-unsuitable password hash; this copy stores passwords as unsalted MD5 to match original data. |
| **Mermaid** | Text-to-diagram syntax used for the diagrams in `docs/diagrams/`. |
| **Migration** | A versioned database change. None are used; the schema is applied from `db/init/`. |
| **MVC** | Model–View–Controller, the architectural pattern CodeIgniter uses. |
| **Model** | MVC layer for data access (`application/models/`; many are Grocery CRUD models). |
| **phpMyAdmin** | Web UI for MySQL, provided by the Docker stack on port 8081. |
| **Schema** | The table definitions; here `db/init/01-schema.sql` (18 tables). |
| **Seed** | Sample data inserted on first boot (`db/init/02-seed.sql`). |
| **Session fixation** | An attack where an attacker fixes a victim's session id; mitigated here by regenerating the id on login. |
| **Smoke test** | A fast end-to-end check that the app boots, logs in once and renders every module (`make smoke`). |
| **SQL injection** | Injecting SQL via unsanitised input; the legacy login query is vulnerable (documented in [SECURITY](SECURITY.md)). |
| **Study-Only Source License** | The repository's source-available licence: free for non-commercial study, testing, self-hosting and sharing; no commercial or production use and no misrepresentation (see [LICENSE](../LICENSE)). |
| **VAT** | Value-Added Tax; the app produces VAT invoices. |
| **`tb_sf_login`** | The application's user table. The `sf_` prefix is a legacy, opaque naming convention. |
| **View** | MVC layer with the HTML/templates (`application/views/`). |
