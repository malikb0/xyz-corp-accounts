# Development

## Conventions

- **Framework:** CodeIgniter 3 MVC. One controller per module; Grocery CRUD
  models for standard tables.
- **Configuration:** never hard-code environment values — read with `getenv()`
  and document the variable in `.env.example`.
- **URLs:** always build links with `base_url()` / `site_url()`, never with a
  literal host.
- **Theming:** CRUD modules select a Grocery CRUD theme with
  `$crud->set_theme('bootstrap')` (available: `bootstrap`, `datatables`,
  `flexigrid`). The admin chrome uses the SB Admin 2 theme in `admin_resources/`.
- **File names:** controller **class** names must be valid PHP identifiers — do
  not put hyphens in controller filenames (see the legacy
  `Vendors_multigrid-nill.php`, which is unreachable for this reason).

## Adding a CRUD module

1. **Table** exists in `db/init/01-schema.sql` (or your own migration).
2. **Model** in `application/models/` extending `Grocery_crud_model` (or reuse
   it directly).
3. **Controller** in `application/controllers/`:

   ```php
   <?php
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   class Example extends CI_Controller {
       public function __construct() {
           parent::__construct();
           $this->load->helper('url');
           $this->load->database($this->session->userdata['logged_in']['dbgroup']);
           $this->load->library('grocery_CRUD');
       }

       public function index() {
           $crud = new Grocery_CRUD();
           $crud->set_theme('bootstrap');
           $crud->set_table('tb_example');
           $crud->set_subject('Example');
           $output = $crud->render();
           $this->load->view('admin_page.php', $output);
       }
   }
   ```

4. **Route** (optional) in `application/config/routes.php` if the URL should not
   match the class name.
5. **Menu** entry in `application/views/admin-nav.php`.
6. Verify with `make smoke` (the controller is picked up automatically if you add
   it to the script's `CONTROLLERS` array).

## Running while developing

The repo is bind-mounted into the `app` container, so PHP edits take effect
immediately. Only the `Dockerfile` (extensions/Apache config) needs a rebuild.

```bash
make up
make logs SVC=app
make shell        # bash inside the app container
make db           # mysql shell
```

## Documentation

- Diagrams live in `docs/diagrams/*.mmd` (Mermaid). After editing, run
  `make render-docs` to refresh the SVGs in `docs/assets/`.
- Keep `docs/FILE_CATALOG.md` and `docs/STRUCTURE.md` in step with the tree.

## Git

- Commit locally with themed messages; the database volume, `.env`, uploads and
  `db/private/` are ignored.
- Do not commit real data or credentials.
