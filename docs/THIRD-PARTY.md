# Third-party components

`xyz-corp-accounts` is **source-available under a study-only licence** — see
[`../LICENSE`](../LICENSE). This file records only the **third-party components**
it bundles and the licences that govern those components. Those licences do **not**
apply to the application's own source.

## PHP / framework

| Component | Version | Licence | Location |
|---|---|---|---|
| CodeIgniter | 3.1.13 | MIT | `system/`, `index.php` |
| Grocery CRUD | 1.6.4 | MIT **or** GPL-3.0 (dual) | `application/libraries/Grocery_CRUD.php`, `assets/grocery_crud/` |
| image_moo | 1.0.1 | MIT | `application/libraries/image_moo.php` |
| I18N Arabic (Khaled Al-Shamali) | bundled | LGPL | `application/views/I18N/` |

Licence texts: `licenses/CodeIgniter-MIT.txt`,
`assets/grocery_crud/license-*.txt`, `application/views/I18N/Arabic/{GPL,LGPL}`.

## Front end

| Component | Licence | Location |
|---|---|---|
| SB Admin 2 (Start Bootstrap, Bootstrap 3 line) | MIT | `admin_resources/` |
| Bootstrap 3 | MIT | `admin_resources/vendor/bootstrap/` |
| jQuery 3.5.1 | MIT | `admin_resources/vendor/jquery/jquery-3.5.1.min.js` |
| jQuery UI 1.12.1 | MIT | `assets/jquery_ui/` |
| Font Awesome | CC BY 4.0 / SIL OFL / MIT | `admin_resources/vendor/font-awesome/` |
| metisMenu | MIT | `admin_resources/vendor/metisMenu/` |
| morris.js | BSD-2-Clause | `admin_resources/vendor/morrisjs/` |
| raphael | MIT | `admin_resources/vendor/raphael/` |
| printThis | MIT | `assets/print_jq/printThis.js` |
| Grocery CRUD bootstrap theme | MIT / GPL-3.0 (per Grocery CRUD) | `assets/grocery_crud/themes/bootstrap/` |

## Reconstructed in this copy

Parts of the original deployment that were not in this copy were reinstated from
their upstream packages (matching versions where possible):

- CodeIgniter 3.1.13 core.
- Grocery CRUD 1.6.4 assets and the `bootstrap` theme.
- SB Admin 2 (Bootstrap 3) admin theme, jQuery UI 1.12.1, printThis.

See [`CHANGELOG-restoration.md`](CHANGELOG-restoration.md).
