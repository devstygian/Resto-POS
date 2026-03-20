# Resto-POS (Nadine-system) Documentation

## 1) Project Overview
- Application: Restaurant POS (Point of Sale).
- Stack: PHP + MySQL + vanilla JavaScript + HTML/CSS.
- Purpose: manage menu, orders, customers, staff, and sales analytics.

## 2) Environment Setup
1. Install XAMPP or similar (Apache + MySQL).
2. Place project in web root (e.g. `C:\xampp\htdocs\Nadine-system`).
3. Create MySQL database `ordering_system`.
4. Import schema and seed data as needed (not included in this summary).
5. Open `src/config/config.php` to configure DB credentials and base URL.

## 3) Config and Authentication
- `src/config/config.php`:
  - Starts session.
  - Connects to MySQL: `new mysqli("localhost", "root", "", "ordering_system")`.
  - Sets `base_url = "http://localhost/Nadine-system/"`.
  - `checkLogin()`: redirects to `auth/login.php` if not signed in.
  - `checkRole($roles)`: redirects to `auth/unauthorized.php` when unauthorized.

## 4) Key Modules and Responsibilities
- `auth/`: login/logout/unauthorized.
- `src/dashboard/`: stat endpoints for charts.
- `src/manage/`: menu CRUD and management.
- `src/menu/`: menu browsing, search, checkout.
- `src/order/`: order list, details, status update, payments, search.
- `src/accounts/`: staff accounts management.
- `src/users/`: customer and user dashboards.
- `assets/`: CSS and JS behavior.

## 5) Data Endpoints
### `db/fetch_data.php`
- Requires login.
- Outputs monthly sales JSON by payment status using query on `order_items` + `orders`.
- Return format:
  - `month`, `paid_total`, `pending_total`, `refunded_total`, `total`.

## 6) Auth Flow (common pattern)
1. Script includes `src/config/config.php`.
2. Calls `checkLogin()` at top.
3. Optional `checkRole([...])` for role-based access.
4. Runs query logic and renders output (HTML or JSON).

## 7) Security Notes and Improvements
- Many scripts use direct SQL concatenation with `$_POST`/`$_GET`: SQL injection risk.
- No CSRF tokens.
- No explicit input validation or sanitization paths in this module.
- Recommended: move to prepared statements, strict parameter validation, CSRF protection.

## 8) Quick References for Developers
- Login required pages include `checkLogin()`.
- Navigation and UI share components in `src/include/sidebar.php`.
- For new API endpoint: use same pattern, echo JSON, central include config/auth.

## 9) Next tasks (low effort)
- Add `README.md` update to document routes and schema.
- Add `docs/architecture.md` with data diagram and models.
- Build an `api-docs` for UI chart services.

## 10) Detailed Module Summary (from initial architecture analysis)
- `auth` handles login session and unauthorized view.
- `src/config/config.php` manages session, DB, base URL, role guard.
- `dashboard` endpoints are JSON data sources for graphs.
- `manage` endpoint pages handle menu create/read/update/delete.
- `menu` folder serves public-facing menu, search and checkout.
- `order` folder serves order lifecycle (list, details, status updates, payment updates).
- `accounts` maintains staff users and profile actions.
- `users` are UI / dashboards for customers, maybe listing.

## 11) Endpoint Reference Table
| Route | Type | Description |
|---|---|---|
| `auth/login.php` | Web form | Login page |
| `auth/logout.php` | Action | Destroy session and redirect |
| `auth/unauthorized.php` | Web page | Role denied status |
| `db/fetch_data.php` | JSON API | Monthly sales by payment status |
| `src/dashboard/weekly_sales.php` | JSON API | Weekly sales data |
| `src/dashboard/monthly_sales.php` | JSON API | Monthly sales data |
| `src/dashboard/recent_orders.php` | JSON API | Latest orders list |
| `src/manage/add_menu.php` | Action | Insert new menu item |
| `src/manage/update_menu.php` | Action | Update existing menu item |
| `src/manage/delete_menu.php` | Action | Delete menu item |
| `src/order/orders.php` | UI + data | List orders with pending/paid status |
| `src/order/update_status.php` | Action | Change order status (processing/delivered) |
| `src/order/upPayment_status.php` | Action | Update payment status |
| `src/accounts/register.php` | Action | Add staff account |
| `src/accounts/edit_acc.php` | UI form | Edit staff account |

## 12) Quick 1-minute pitch 
- `config.php` enforces login and DB; every protected page includes it.
- Each feature area lives in a folder by domain (dashboard/manage/order/accounts).
- Actions often use `$_POST`, SQL string build, then redirect.
- Visualization data endpoints provide JSON to JS charts.

## 13) Improvements planned in this doc
- Add automated tests (if moving to frameworks).
- Document SQL schema (tables/columns + indexes) with ER diagram.
- Add code style guidelines (PSR-12 or custom) and security checklist.

