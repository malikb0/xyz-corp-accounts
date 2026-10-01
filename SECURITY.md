# Security Policy

## Supported versions

This is a **preserved legacy application** provided for **non-commercial study,
testing and evaluation only** (see [`LICENSE`](LICENSE)). It is **not supported for production use**
and receives no security fixes as a product. The stack is intentionally pinned to
end-of-life software (PHP 7.4, MySQL 5.7) to reproduce a 2016–2022 codebase.

**Do not deploy this on the public internet.**

## Known limitations

The application retains several legacy security practices (unsalted MD5 password
storage, a string-built login query, CSRF protection off, an application
encryption key left unset). These are documented, with remediation notes, in
[`docs/SECURITY.md`](docs/SECURITY.md). They are preserved so that original data
still authenticates.

## Reporting a vulnerability

If you find a security issue, please report it **privately** rather than opening a
public issue:

- Use GitHub's **Report a vulnerability** (Security advisories) for this
  repository, or
- Contact the maintainer directly via the address on their GitHub profile.

Please include steps to reproduce and the affected file/route. As this is a study
archive, reports are handled on a best-effort basis and are most useful as
documentation of the legacy behaviour.
