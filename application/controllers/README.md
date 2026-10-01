# application/controllers/

One controller per module. See [../../docs/MODULES.md](../../docs/MODULES.md) for
descriptions and themes.

| Controller | Kind |
|---|---|
| `User_Authentication.php` | Login / logout / dashboard |
| `Welcome.php` | Default route |
| `Accounts.php` | CRUD (accounts / parties) |
| `Arabic_description.php` | CRUD (EN/AR descriptions) |
| `Employees_data.php` | CRUD (employees) |
| `Expenses.php` | CRUD (expenses) |
| `Investments.php` | CRUD (investments) |
| `Transactions.php` | CRUD (transactions) |
| `Owner_transactions.php` | CRUD (owner transactions) |
| `Profits.php` | CRUD (profits) |
| `Vehicles_data.php` | CRUD (vehicles) |
| `Rental_equipments.php` | CRUD (rental equipment) |
| `Trips.php` | CRUD (trips) |
| `Orders.php` | CRUD (orders) |
| `Order_items.php` | CRUD (order items) |
| `Vendor_contracts.php` | CRUD (vendor contracts) |
| `Vendor_items.php` | CRUD (vendor items) |
| `Upload_invoices.php` | CRUD (invoice uploads) |
| `Invoice.php` | Custom invoice screen |
| `Vat_invoice.php` | Custom VAT invoice |
| `Vat_invoice_1.php` | Alternate VAT invoice |
| `Salary_slip.php` | Custom salary slip |
| `Data_reports.php` | Operational reports |
| `Get_report.php` | Financial reports |
| `Vendors_multigrid-nill.php` | Legacy, unreachable (hyphen in filename) |

Every controller selects its database connection group from the session
(`logged_in['dbgroup']`) before querying.
