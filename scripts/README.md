# scripts/

| Script | Purpose |
|---|---|
| `smoke-test.sh` | End-to-end check: logs in once and requests every module, failing on any PHP error. Run with `make smoke`. |
| `gen-catalog.sh` | Regenerates `../docs/FILE_CATALOG.md` from the tree. |

All are plain Bash and safe to read/edit.
