# Contributing

This repository is a **personal study/reference copy** published under a
[study-only licence](LICENSE). It is **not an open-source project**; it is shared
for non-commercial study, testing and evaluation, and is **not accepting external
contributions** (pull requests or feature work).

## You are welcome to

- Read, run and study the code locally.
- Open a **bug report or security report** (see [`SECURITY.md`](SECURITY.md)) if
  something is wrong with the working copy as published.

## Please do not

- Submit feature PRs — they are not accepted for this study copy.
- Use the code commercially or in production, or present it as your own work.

## Local development

```bash
cp .env.example .env      # adjust if needed
make up                   # build + start (app :8080, phpMyAdmin :8081)
make smoke                # single login + every module
make reset                # wipe the DB volume and re-seed
make down                 # stop
```

See [`docs/DEVELOPMENT.md`](docs/DEVELOPMENT.md) for conventions and how to add a
module, and [`docs/STRUCTURE.md`](docs/STRUCTURE.md) for the layout.
