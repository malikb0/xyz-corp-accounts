# assets/

Web-root assets used by the application.

| Path | Contents |
|---|---|
| `grocery_crud/` | Grocery CRUD 1.6.4 assets: `themes/` (bootstrap, datatables, flexigrid), `js/`, `css/`, `languages/`, `config/`, `texteditor/` |
| `jquery_ui/` | jQuery UI 1.12.1 (`jquery-ui.js`, `jquery-ui.css`, `theme.css`) |
| `print_jq/` | `printThis.js` printing plugin |
| `css/` | Project stylesheet (`general-common-custom.css`) |
| `uploads/files/` | Upload targets for Grocery CRUD file fields (runtime, git-ignored) |

## Upload folders

Each `uploads/files/<name>` corresponds to a `set_field_upload(...)` call:
`emp-pic`, `fatora`, `insurance`, `invoices`, `investment-references`,
`transaction-references`, `trip-docs`, `aramco-id`, `fahas`, `iqama`,
`istamara`, `license`, `meezan-card`, `other-employee-files`,
`other-vehicle-files`, `passport`, `sticker`, `tafweez`.

Uploaded files are not committed; the folders are kept with an `index.html`
guard.
