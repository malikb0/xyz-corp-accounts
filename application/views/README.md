# application/views/

Layout partials, module screens, printable documents and the Arabic I18N library.

## Admin layout

| File | Purpose |
|---|---|
| `admin-head.php` | `<head>`: theme CSS + project stylesheet |
| `admin-js.php` | Theme/plugin JavaScript |
| `admin-nav.php` | Sidebar / top navigation (module menu) |
| `admin-notifications.php` | Dashboard notifications panel |
| `display-panel.php` | Dashboard summary tiles |
| `admin_page.php` | Admin shell that includes the partials above |

## Screens

| File | Used by |
|---|---|
| `login_form.php`, `registration_form.php` | `User_Authentication` |
| `invoice_view.php` | `Invoice` |
| `vat_invoice_view.php`, `vat_invoice_view_1.php` | `Vat_invoice`, `Vat_invoice_1` |
| `salary_view.php` | `Salary_slip` |
| `report_view.php` | `Get_report` |
| `data_reports_view.php` | `Data_reports` |
| `output_page.php`, `ntow.php`, `welcome_message.php` | Misc / default |
| `index.html`, `index_1.html` | Directory guards |
| `errors/` | CodeIgniter error templates |
| `I18N/` | Vendored Arabic language library (LGPL) |

Views build links with `base_url()` / `site_url()` and never contain a literal
host.
