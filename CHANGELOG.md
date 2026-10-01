# Changelog

This file records notable changes to this repository. It follows the spirit of
[Keep a Changelog](https://keepachangelog.com/); the **detailed, itemised** log of
the restoration and refactoring work lives in
[`docs/CHANGELOG-restoration.md`](docs/CHANGELOG-restoration.md).

## [Unreleased]

### Added
- Root community/standard files: `NOTICE`, `SECURITY.md`, this `CHANGELOG.md`.
- Self-contained stack badges and app screenshots.
- `docs/GLOSSARY.md`; `CONTRIBUTING.md`; `CODE_OF_CONDUCT.md`.
- `.editorconfig`.

### Changed
- Licence set to the **Study-Only Source License**: source-available for
  non-commercial study, testing, self-hosting and sharing; commercial and
  production use, and misrepresentation, are not permitted.
- **Authorization removed for simplicity** — the app now enforces a single
  authentication layer; every logged-in user reaches every module.

### Removed
- Residual references to the original client's identity from documentation,
  configuration comments and seed data.
- GitHub Actions CI (`.github/workflows/ci.yml`): it cannot fully run on hosted
  runners, so the stack and smoke test are run locally with `make up` / `make smoke`.

---

For the full history of the restoration (framework/assets reconstruction,
environment-driven config, de-branding, authorization history, documentation,
Docker stack), see [`docs/CHANGELOG-restoration.md`](docs/CHANGELOG-restoration.md).
