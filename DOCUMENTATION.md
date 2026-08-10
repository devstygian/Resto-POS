# Resto-POS — System Documentation

> **Restaurant Point-of-Sale & Management System**
> Academic Capstone Project

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Objectives](#2-objectives)
3. [System Architecture](#3-system-architecture)
4. [Technology Stack](#4-technology-stack)
5. [Project Structure](#5-project-structure)
6. [System Roles](#6-system-roles)
7. [Core Modules](#7-core-modules)
8. [Authentication & Authorization](#8-authentication--authorization)
9. [Order Management](#9-order-management)
10. [Menu Management](#10-menu-management)
11. [Dashboard & Analytics](#11-dashboard--analytics)
12. [Database](#12-database)
13. [Application Flow](#13-application-flow)
14. [Installation & Setup](#14-installation--setup)
15. [Configuration](#15-configuration)
16. [Security](#16-security)
17. [Development Guidelines](#17-development-guidelines)
18. [Troubleshooting](#18-troubleshooting)
19. [Known Limitations](#19-known-limitations)
20. [Future Development](#20-future-development)
21. [Contributing](#21-contributing)
22. [Project Status](#22-project-status)

---

# 1. Project Overview

**Resto-POS** is a web-based Restaurant Point-of-Sale and Management System developed as an academic capstone project.

The system is designed to assist restaurant staff and administrators in managing daily restaurant operations, including:

* Menu management
* Customer orders
* Order status tracking
* Payment status management
* Staff account management
* Sales monitoring
* Dashboard analytics
* Customer-facing ordering workflows

The application uses a traditional server-side PHP architecture with a JavaScript-powered frontend and MySQL as its primary data store.

> **Project Classification:** Academic / Educational
> **Primary Environment:** XAMPP
> **Architecture:** PHP-based web application

---

# 2. Objectives

The primary objectives of Resto-POS are to:

1. Digitize common restaurant ordering and management processes.
2. Reduce reliance on manual order tracking.
3. Provide centralized menu and order management.
4. Allow authorized staff to monitor and update orders.
5. Provide administrators with sales and operational insights.
6. Establish a foundation for future online ordering and payment integrations.
7. Demonstrate practical implementation of database-driven web application development.

---

# 3. System Architecture

Resto-POS follows a traditional web application architecture.

```text
┌──────────────────────────────┐
│          Client              │
│                              │
│  HTML / CSS / JavaScript     │
└──────────────┬───────────────┘
               │ HTTP
               ▼
┌──────────────────────────────┐
│        PHP Application       │
│                              │
│ Authentication               │
│ Business Logic               │
│ CRUD Operations              │
│ Order Processing             │
│ Dashboard Services           │
└──────────────┬───────────────┘
               │ MySQLi
               ▼
┌──────────────────────────────┐
│          MySQL               │
│                              │
│ Users                        │
│ Menu                         │
│ Orders                       │
│ Order Items                  │
│ Related Data                 │
└──────────────────────────────┘
```

### Architectural Components

| Layer          | Responsibility                            |
| -------------- | ----------------------------------------- |
| Presentation   | HTML, CSS and JavaScript interfaces       |
| Application    | PHP business logic and request processing |
| Authentication | Session management and role validation    |
| Data Access    | MySQLi database queries                   |
| Database       | Persistent application data               |
| Server         | Apache through XAMPP                      |

---

# 4. Technology Stack

| Category                | Technology     |
| ----------------------- | -------------- |
| Frontend                | HTML5          |
| Styling                 | CSS3           |
| Client-side Logic       | JavaScript     |
| Backend                 | PHP            |
| Programming Style       | Procedural PHP |
| Database                | MySQL          |
| Database Driver         | MySQLi         |
| Local Server            | Apache         |
| Development Environment | XAMPP          |
| Icons                   | Font Awesome   |
| Version Control         | Git            |
| Repository Hosting      | GitHub         |

The current repository identifies PHP, MySQL, HTML, CSS, JavaScript, XAMPP, and Font Awesome as its primary technologies.

---

# 5. Project Structure

The repository currently organizes the main application under the `admin/` directory.

```text
Resto-POS/
│
├── admin/
│   │
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── ...
│   │
│   ├── auth/
│   │   ├── login.php
│   │   ├── logout.php
│   │   └── unauthorized.php
│   │
│   ├── db/
│   │   └── database-related files
│   │
│   ├── src/
│   │   ├── accounts/
│   │   ├── dashboard/
│   │   ├── include/
│   │   ├── manage/
│   │   ├── menu/
│   │   ├── order/
│   │   └── users/
│   │
│   └── dashboard.php
│
├── .gitignore
├── CONTRIBUTING.md
├── DOCUMENTATION.md
├── LICENSE
├── README.md
├── SECURITY.md
├── TODO.md
└── function.md
```

### Directory Responsibilities

#### `admin/`

Contains the primary administrative application.

#### `admin/assets/`

Contains frontend resources such as:

* CSS stylesheets
* JavaScript files
* Images
* UI resources

#### `admin/auth/`

Handles authentication-related functionality.

Typical responsibilities include:

* Login
* Logout
* Unauthorized access handling
* Session-related operations

#### `admin/db/`

Contains database-related scripts and data access services.

#### `admin/src/accounts/`

Responsible for staff account management.

#### `admin/src/dashboard/`

Contains dashboard-related services and data endpoints used for analytics.

#### `admin/src/include/`

Contains reusable interface components such as navigation and sidebar elements.

#### `admin/src/manage/`

Contains administrative management functionality, particularly menu-related CRUD operations.

#### `admin/src/menu/`

Contains menu browsing, item selection, search and ordering functionality.

#### `admin/src/order/`

Handles the order management lifecycle, including:

* Order listing
* Order details
* Order status
* Payment status
* Order searching/filtering

#### `admin/src/users/`

Contains customer/user-facing functionality.

---

# 6. System Roles

Resto-POS uses role-based access control to separate administrative and staff functionality.

## Administrator

Administrators are responsible for managing the system and its configuration.

Typical responsibilities include:

* Managing menu items
* Managing staff accounts
* Viewing dashboard analytics
* Monitoring orders
* Managing operational data

## Staff

Staff members primarily interact with operational functionality.

Typical responsibilities include:

* Viewing orders
* Processing orders
* Updating order statuses
* Managing customer orders
* Updating payment-related information

> Access to specific functionality should always be enforced on the server side rather than relying solely on frontend navigation.

---

# 7. Core Modules

## 7.1 Authentication

The authentication module provides:

* Login
* Logout
* Session management
* Role validation
* Unauthorized access handling

Authentication is required before users can access protected administrative functionality.

---

## 7.2 Menu Management

Administrators can manage restaurant menu items.

Supported operations include:

* Create menu items
* View menu items
* Update menu items
* Delete menu items
* Organize menu categories
* Manage menu images
* Maintain item pricing

This module provides the primary source of menu information used by the ordering system.

---

## 7.3 Order Management

The order module manages the lifecycle of customer orders.

Typical operations include:

```text
Customer Order
      │
      ▼
   Pending
      │
      ▼
  Preparing
      │
      ▼
    Ready
      │
      ▼
  Completed
```

Orders may also be cancelled depending on the applicable workflow.

The system also maintains payment-related states separately from food/order processing.

---

## 7.4 Payment Management

Payment information is associated with customer orders.

Supported payment states include:

| Status     | Meaning                                        |
| ---------- | ---------------------------------------------- |
| `Pending`  | Payment has not yet been completed             |
| `Paid`     | Payment has been completed                     |
| `Refunded` | Previously completed payment has been refunded |

Payment processing should be treated separately from order fulfillment.

---

## 7.5 Dashboard & Analytics

The dashboard provides operational and sales information.

Possible dashboard metrics include:

* Total sales
* Total orders
* Total customers
* Total items sold
* Recent orders
* Weekly sales
* Monthly sales

Chart-oriented PHP endpoints provide JSON data that can be consumed by JavaScript visualization components.

---

# 8. Authentication & Authorization

The application uses PHP sessions to maintain authenticated user state.

A typical protected page follows this flow:

```text
Request
   │
   ▼
Load Configuration
   │
   ▼
Start / Resume Session
   │
   ▼
Check Authentication
   │
   ├── Not Authenticated ──► Login
   │
   ▼
Check User Role
   │
   ├── Unauthorized ──► Unauthorized Page
   │
   ▼
Execute Application Logic
```

### Authentication Requirements

Protected pages should:

1. Load the central configuration.
2. Start or resume the session.
3. Verify that the user is authenticated.
4. Validate the user's role when required.
5. Only then execute protected operations.

---

# 9. Order Management

The order system is responsible for maintaining the complete lifecycle of an order.

## Order Information

An order may contain:

* Customer information
* Order identifier
* Ordered menu items
* Quantity
* Item price
* Order status
* Payment status
* Order date/time
* Delivery or fulfillment information

## Order Status

The order workflow uses status values representing the current state of food preparation and fulfillment.

```text
Pending
   ↓
Preparing
   ↓
Ready
   ↓
Completed
```

Orders may transition to:

```text
Cancelled
```

when an order is cancelled before completion.

---

# 10. Menu Management

Menu management provides administrators with CRUD functionality.

### Create

Administrators can add new menu items and define relevant information such as:

* Item name
* Category
* Description
* Image
* Pricing
* Availability

### Read

Menu data can be displayed through administrative and customer-facing interfaces.

### Update

Existing menu items can be modified when prices, descriptions, images or other information change.

### Delete

Menu items can be removed when they are no longer available.

---

# 11. Dashboard & Analytics

The dashboard acts as an operational overview for authorized users.

Analytics endpoints can provide structured JSON data for frontend charts.

Example response structure:

```json
{
  "month": "January",
  "paid_total": 15000,
  "pending_total": 2500,
  "refunded_total": 500,
  "total": 18000
}
```

The exact response structure may vary depending on the endpoint.

### Current Analytics Areas

* Weekly sales
* Monthly sales
* Recent orders
* Payment-based sales summaries

---

# 12. Database

Resto-POS uses **MySQL** for persistent storage.

The database stores information required for:

* Users
* Staff accounts
* Menu items
* Orders
* Order items
* Customer information
* Payment status
* Order status

The database should be treated as the authoritative source for transactional information.

## Recommended Database Relationship

```text
Users
  │
  └──────────────┐
                 │
                 ▼
              Orders
                 │
                 │ 1:N
                 ▼
            Order Items
                 │
                 │ N:1
                 ▼
              Menu Items
```

An order can contain multiple order items, while each order item references a menu item.

---

# 13. Application Flow

## Customer Ordering Flow

```text
Open Menu
    │
    ▼
Browse / Search Items
    │
    ▼
Select Item
    │
    ▼
Add to Cart
    │
    ▼
Review Order
    │
    ▼
Checkout
    │
    ▼
Create Order
    │
    ▼
Track Order
```

## Staff Workflow

```text
Login
  │
  ▼
Dashboard
  │
  ▼
View Orders
  │
  ▼
Review Order
  │
  ▼
Update Status
  │
  ▼
Complete / Cancel
```

## Administrator Workflow

```text
Login
  │
  ▼
Dashboard
  │
  ├──► Menu Management
  │
  ├──► Order Management
  │
  ├──► Staff Accounts
  │
  └──► Sales Analytics
```

---

# 14. Installation & Setup

## Requirements

Before running the system, install:

* XAMPP
* Apache
* MySQL
* PHP
* Git
* A modern web browser

## Clone the Repository

```bash
git clone https://github.com/devstygian/Resto-POS.git
```

Move into the project directory:

```bash
cd Resto-POS
```

---

## Configure XAMPP

Move the project into the XAMPP web root:

```text
C:\xampp\htdocs\Resto-POS
```

Start the following services from XAMPP:

```text
Apache
MySQL
```

---

## Configure the Database

Open:

```text
http://localhost/phpmyadmin
```

Create the required database and import the project's SQL schema.

Example:

```sql
CREATE DATABASE ordering_system;
```

> Use the database name and schema expected by the current application configuration.

---

## Configure Database Credentials

Locate the application's database configuration file and update the connection values according to the local environment.

Typical local configuration:

```text
Host: localhost
Username: root
Password: [your local MySQL password]
Database: ordering_system
```

Do not commit production credentials or secrets to the repository.

---

## Run the Application

After Apache and MySQL are running, open:

```text
http://localhost/Resto-POS/
```

If the application is installed under a different directory, update the configured base URL accordingly.

---

# 15. Configuration

Centralized configuration should contain environment-specific values such as:

* Database host
* Database username
* Database password
* Database name
* Application base URL
* Session configuration

Example:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "ordering_system";
```

### Important

Configuration values should be separated from application logic whenever possible.

For production deployments, sensitive credentials should be stored using environment variables or a secure configuration mechanism rather than hard-coded values.

---

# 16. Security

Security is an important consideration because the application processes authentication credentials and customer/order information.

## Current Security Measures

The project uses password hashing through PHP's password hashing functionality.

The repository also documents protection against SQL injection as a security goal.

## Recommended Security Practices

### Password Security

Passwords should never be stored in plaintext.

Use:

```php
password_hash()
```

for password storage and:

```php
password_verify()
```

for authentication.

### SQL Injection Prevention

Use prepared statements instead of directly concatenating user input into SQL queries.

Preferred:

```php
$stmt = $conn->prepare(
    "SELECT * FROM users WHERE username = ?"
);

$stmt->bind_param("s", $username);
$stmt->execute();
```

Avoid:

```php
$query = "SELECT * FROM users WHERE username = '$username'";
```

### CSRF Protection

State-changing requests should include CSRF protection.

Recommended for:

* Creating records
* Updating records
* Deleting records
* Changing order status
* Changing payment status

### Input Validation

Validate all data received through:

```text
$_GET
$_POST
$_FILES
```

Validation should occur server-side even when frontend validation is present.

### Session Security

Authenticated sessions should use secure session practices, including:

* Session regeneration after login
* Secure cookies
* Appropriate session expiration
* Server-side authorization checks

---

# 17. Development Guidelines

## Naming

Use descriptive names for:

* Variables
* Functions
* Files
* Database columns
* Endpoints

## PHP

Keep database operations and business logic organized by module.

Avoid duplicating:

* Database connections
* Authentication checks
* Common UI components
* Validation logic

## JavaScript

Keep frontend behavior separated into dedicated JavaScript files when practical.

Use JavaScript primarily for:

* UI interactions
* AJAX/fetch requests
* Form behavior
* Dynamic content
* Charts

## CSS

Keep reusable styles centralized instead of duplicating styles throughout PHP files.

---

# 18. Troubleshooting

## CSS or JavaScript Not Loading

Check the browser's developer tools:

```text
F12 → Network
```

Look for:

```text
404 Not Found
```

Verify that asset paths correctly match the current application URL.

For example:

```text
http://localhost/Resto-POS/admin/assets/...
```

rather than an outdated project path.

---

## Page Redirects to an Unexpected Location

Check:

* Application base URL
* PHP redirect paths
* Session authentication logic
* Relative versus absolute URLs
* `.htaccess` rules if applicable

A hard-coded path referencing an old project directory can cause unexpected redirects.

---

## Database Connection Failed

Verify:

1. MySQL is running.
2. Database name is correct.
3. Username is correct.
4. Password is correct.
5. Host is correct.
6. PHP MySQLi support is enabled.

---

## Login Does Not Work

Check:

* Database user exists.
* Password hash is valid.
* `password_verify()` is being used correctly.
* PHP sessions are enabled.
* Authentication redirects are correct.
* The user's role matches the required permissions.

---

# 19. Known Limitations

Resto-POS is currently an academic project and should not be considered production-ready without additional security, testing, scalability and deployment work.

Potential limitations include:

* Procedural PHP architecture
* Limited automated testing
* Environment-specific configuration
* Local XAMPP dependency during development
* Additional security hardening required for production
* Limited API standardization
* No dedicated production deployment architecture
* Additional validation and error handling required

These limitations are consistent with the repository's stated academic-project scope.

---

# 20. Future Development

Potential future improvements include:

### Customer-Facing Ordering Platform

Develop a dedicated landing page and online ordering interface.

### Payment Integration

Support external payment providers for online transactions.

### Google Authentication

Provide optional third-party authentication for customer accounts.

### REST API

Introduce a structured API layer to separate frontend and backend responsibilities.

### Modern Frontend

Potentially migrate selected interfaces toward a modern frontend framework such as Vue.js or React.

### Improved Security

Implement:

* CSRF protection
* Prepared statements throughout the system
* Strict input validation
* Rate limiting
* Secure session configuration
* Environment-based secrets

### Automated Testing

Introduce:

* Unit tests
* Integration tests
* Authentication tests
* Database tests
* End-to-end tests

### Deployment

Move beyond local XAMPP development toward a structured deployment environment.

---

# 21. Contributing

Contributions should follow the project's established Git workflow.

## Create a Feature Branch

```bash
git checkout -b feature/your-feature-name
```

## Make Changes

Implement and test the requested change.

## Commit

Use the project's conventional commit format:

```bash
git add .
git commit -m "feat: add new feature"
```

## Push

```bash
git push origin feature/your-feature-name
```

## Pull Request

Open a Pull Request describing:

* What changed
* Why it changed
* How it was tested
* Any known limitations

Before contributing, review:

* `CONTRIBUTING.md`
* `SECURITY.md`

---

# 22. Project Status

**Current Status:** Active Academic Development

Resto-POS has evolved from a basic restaurant ordering/POS concept into a broader restaurant management platform. The repository currently contains administrative functionality covering authentication, menu management, orders, accounts and dashboard-related functionality.

Future development is expected to expand the platform toward customer-facing online ordering and external service integrations.

---

## Repository

**GitHub:**
https://github.com/devstygian/Resto-POS

## License

This project is distributed under the repository's MIT License.

---

## Disclaimer

Resto-POS is developed for academic and educational purposes.

It is not intended for production deployment without appropriate security auditing, testing, infrastructure configuration, data protection measures and operational hardening.

---

**Resto-POS**
*Restaurant Point-of-Sale & Management System*

© 2026 DevStygian
