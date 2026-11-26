# Laundry Shop Management System

A PHP/MySQL reconstruction based on the supplied screen recordings and tracking screenshot.

## Requirements
- PHP 8.2+ with PDO MySQL extension
- MySQL 8+
- Apache (XAMPP/WAMP/LAMP) or PHP's built-in server

## Install (XAMPP)
1. Copy the `laundry_management_system` folder into `htdocs`.
2. Open `config.php` and set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` for your MySQL setup.
3. Start Apache and MySQL.
4. Visit `http://localhost/laundry_management_system/install.php`.
5. Visit `http://localhost/laundry_management_system/login.php`.

## Initial administrator
- Username: `ghelo123`
- Temporary password: `admin123`
- Change this password immediately in Admin Workspace → Settings.
- Delete `install.php` after successful installation.

## Customer tracking
The public homepage is `index.php`. Customers enter their unique tracking code to view order status, services, received date, estimated completion, total, paid amount, and balance. Each new admin order receives a unique `LD-XXXX-XXXX` tracking code.

## Modules included
Dashboard, customers, orders, status workflow, public tracking, machines, pickup queue, payments, reports/expenses, services and pricing, inventory/stock movements, admin accounts, settings, password change, light/dark admin theme.

## Notes
- The UI is responsive and uses the original mint/teal + navy visual direction from the recordings.
- The database schema is in `database.sql`.
- The installer creates the database, tables, starter service prices, and initial administrator account.
- Change default DB credentials and use HTTPS before deploying online.
- For a public deployment, add a formal backup routine, rate limiting, and restrict installation access.
