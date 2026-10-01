# Security

This document states the security posture of the application **honestly**. It is
a faithful restoration of a 2016–2022 internal line-of-business app, not a
hardened product. Nothing below is hidden in the code; it is the original design.

## What was fixed in this copy

| Issue | Original | This copy |
|---|---|---|
| Database credentials in source | 6 sets of hard-coded user/password in `application/config/database.php` | Read from `DB_*` environment variables; nothing in the repo |
| SMTP credentials in source | `application/config/email.php` | Read from `MAIL_*` environment variables |
| Production host hard-coded | ~16 `http://<host>/...` URLs in views/controllers | `base_url()` / `site_url()` |
| Login request stall | `sleep(20)` on every login POST | Removed |
| Base URL / encryption key / session path | Hard-coded | Environment variables |
| Hard-coded authorization | Inline `role ==` / `username ==` checks in ~20 controllers | Removed for simplicity — this copy keeps authentication only (see [AUTHENTICATION](AUTHENTICATION.md)) |
| Registration password | Stored unhashed while login hashed the input | Now hashed consistently (`md5()`), matching login |
| Session fixation | Session id never rotated on login | `sess_regenerate(TRUE)` after a successful login |

If you ever publish or share the original source, **rotate those credentials** —
they existed in a file that reached personal machines.

## Known legacy weaknesses (preserved, not introduced)

| Area | Detail | File |
|---|---|---|
| Password hashing | **Unsalted MD5** (`sf_password varchar(50)`) | `application/models/Login_database.php` |
| SQL construction | Login builds a `WHERE` clause by string concatenation instead of bound parameters | `application/models/Login_database.php` |
| CSRF | Disabled (`csrf_protection = FALSE`) | `application/config/config.php` |
| Encryption key | Empty by default | `application/config/config.php` (`APP_ENCRYPTION_KEY`) |
| Sessions | `sess_match_ip` off; files driver (session id is now regenerated on login) | `application/config/config.php` |

## Hardening roadmap (if it were revived)

1. Replace MD5 with `password_hash()` / `password_verify()` (migrate on next
   successful login).
2. Parameterise the login query with the Query Builder's `where($col, $val)`.
3. Enable CSRF protection and set a strong `encryption_key`.
4. Enforce HTTPS, secure/HttpOnly cookies, and session IP binding.
5. Add a base controller that enforces the login check centrally (controllers
   currently test the session individually).
6. Restrict upload types/sizes; the upload directories are executable-denied via
   `application/.htaccess` but the web-root `assets/uploads` should also carry a
   deny rule.

## Deployment guidance

Keep this application on a private network. It is designed to store and export
financial data and was never built to be internet-facing.
