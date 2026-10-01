# application/models/

| Model | Purpose |
|---|---|
| `Login_database.php` | Authentication against `tb_sf_login` |
| `Grocery_crud_model.php` | Base Grocery CRUD model (list/insert/update/delete) |
| `grocery_file_model.php` | File/upload fields for Grocery CRUD |
| `Accounts_crudModel.php` | Accounts module |
| `Empdata_crudModel.php` | Employees module |
| `Equipments_crudModel.php` | Rental equipment module |
| `Expenses_crudModel.php` | Expenses module |
| `Investments_crudModel.php` | Investments module |
| `OrderItems_crudModel.php` | Order items module |
| `Orders_crudModel.php` | Orders module |
| `Profits_crudModel.php` | Profits module |
| `Transactions_crudModel.php` | Transactions module |
| `Trips_crudModel.php` | Trips module |
| `Vehicles_crudModel.php` | Vehicles module |
| `Vendoritems_crudModel.php` | Vendor items module |

The `*_crudModel` classes extend the base Grocery CRUD model and are wired to the
corresponding controller and table.
