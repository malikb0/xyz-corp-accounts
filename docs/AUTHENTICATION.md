# Authentication

This working copy uses a **single authentication layer**: a user must be logged
in to reach any module; beyond that, access is not restricted.

## How it works

- Credentials are validated in `User_Authentication::user_login_process()` against
  the `tb_sf_login` table, via `application/models/Login_database.php`.
- On success the session stores `username`, `role`, `db_user` and `acnt_id`, and
  the session id is regenerated (a session-fixation defence).
- Every controller checks `isset($this->session->userdata['logged_in'])` and shows
  the login form when it is absent.
- The stored `db_user` selects the CodeIgniter database connection group used for
  the request — see [ARCHITECTURE](ARCHITECTURE.md#database-connection-groups).

## Authorization was removed for simplicity

An earlier revision of this working copy carried a full **role/permission (RBAC)
layer**: a policy file mapping roles to `<module>.<action>` permissions, an
`Authorization` engine (`can()` / `is()` / `check()` / `apply_crud()`), per-role
row-level scoping and role-based menu gating in every controller and in
`admin-nav.php`.

That layer has been **removed for simplicity**. This is a study/reference copy, not
a production-hardened one — it keeps **authentication only**, so every logged-in
user can reach every module and perform every action. The `role` column remains in
`tb_sf_login` for reference but is no longer enforced anywhere in the code.

The earlier, RBAC-based implementation remains available in the Git history if you
want to compare the two approaches.
