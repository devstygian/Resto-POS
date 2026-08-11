![PHP](https://img.shields.io/badge/PHP-7.4+-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-green)
![License](https://img.shields.io/badge/License-Educational-orange)
![Status](https://img.shields.io/badge/Status-Active-success)

# Restaurant Management System

***Capstone Project*** – A ***"Restaurant Order & Menu Management System"*** built using **PHP**, **MySQL**, and **XAMPP**.
Designed to help restaurant staff efficiently manage menus, orders, and daily operations through a clean and responsive interface.

---

## System Preview
>⚠️Note: The data shown here is for demonstration purposes only and does not represent real data.

### Admin Panel

<p align="center">
  <img src="admin/assets/img/showcase/Dashboard.png" width="30%">
  <img src="admin/assets/img/showcase/Dashboard_0.5.png" width="30%">
  <img src="admin/assets/img/showcase/Menu.png" width="30%">
</p>

<p align="center">
  <img src="admin/assets/img/showcase/Order_list.png" width="30%">
  <img src="admin/assets/img/showcase/Custom_Menu.png" width="30%">
  <img src="admin/assets/img/showcase/Account.png" width="30%">
</p>

<p align="center">
  <img src="admin/assets/img/showcase/Customer_list.png" width="30%">
  <img src="admin/assets/img/showcase/Report.png" width="30%">
</p>

### Staff Panel

<p align="center">
  <img src="admin/assets/img/showcase/staff_dash.png" width="30%">
  <img src="admin/assets/img/showcase/staff_dash_0.5.png" width="30%">
  <img src="admin/assets/img/showcase/View_Orders.png" width="30%">
</p>

---

## Features

  **Menu Management**
  Add, edit, delete, and categorize menu items with images.

  **Order Management**
  Track, update, and filter customer orders in real-time.

  **Dashboard Analytics**
  View sales insights and order summaries.

  **User Authentication**
  Secure login system with role-based access.

  **Security**

  * Password hashing using `password_hash()`
  * Protection against SQL Injection

  **Responsive UI**
  Optimized for desktop and smaller screens.

---

## Tech Stack

| **Category**             | **Technology**                |
|--------------------------|-------------------------------|
|  **Frontend**          | HTML, CSS, JavaScript         |
|  **Backend**           |  PHP (Procedural)             |
|  **Database**          |  MySQL                        |
|  **Server**            | XAMPP                         |
|   **Libraries**         | Font Awesome                  |

---

## Development Progress

* See the [TODO List](TODO.md) for upcoming features and improvements.

---

# Development Timeline

### Phase 1 – Planning & System Definition

* Initially proposed a **[Barangay Management System (Saklaw)](https://github.com/devstygian/Saklaw)** as a potential capstone project.
* Re-evaluated the project scope due to data-gathering and real-world requirements.
* Shifted the project direction toward a **Restaurant Management & POS System**.
* Defined the core system scope, user roles, restaurant workflows, and initial feature requirements.
* Selected the primary technology stack: **PHP, MySQL, HTML, CSS, JavaScript, Bootstrap, and XAMPP**.
* Designed the initial database structure and system interface.

### Phase 2 – Core POS & Management System

* Developed the authentication system with login, logout, and **role-based access control**.
* Implemented the **admin/staff dashboard**.
* Developed **menu management**, including menu creation, editing, listing, pricing, and availability.
* Implemented **stock/inventory management** for monitoring available menu items.
* Developed the **POS and order management system**.
* Established order and food-status workflows such as **Pending, Preparing, Ready, Completed, and Cancelled**.

### Phase 3 – Database & Business Logic Integration

* Connected the application to the **MySQL database**.
* Implemented CRUD operations for system-managed data.
* Integrated database relationships between users, roles, menus, orders, order items, payments, and inventory.
* Implemented order processing and status management.
* Added business logic for pricing, order totals, stock availability, and sales records.
* Developed dashboard metrics and monthly sales/income reporting.

### Phase 4 – Customer-Facing E-Commerce Expansion

* Expanded the system beyond a traditional POS by developing a **customer-facing web ordering platform**.
* Created a public **landing page** for the restaurant.
* Implemented customer menu browsing and online ordering workflows.
* Added cart and checkout functionality.
* Added customer order history and **status-based order tracking**.
* Designed the system so that online orders and in-store POS transactions can operate within the same platform.

### Phase 5 – Authentication & Payment Expansion

* Planned and began integration of **Google Authentication** for customer login.
* Planned integration of **electronic payment processing**, including GCash through a suitable payment gateway/API.
* Designed the payment workflow to support payment verification and transaction records.
* Planned additional notification and order-status updates for customers.

### Phase 6 – Platform Integration & Future Development

* Continue integrating the customer-facing ordering system with the existing POS and management modules.
* Establish a unified workflow between **online ordering, POS transactions, inventory, payments, and reporting**.
* Improve order tracking through automatic status updates and estimated preparation times rather than requiring live GPS tracking.
* Expand reporting and analytics for restaurant performance, sales, inventory, and customer activity.
* Further improve security, role permissions, validation, and system reliability.
* Future direction: evolve Resto-POS from a traditional POS into a **Restaurant Management & E-Commerce Platform** that supports multiple sales channels through one centralized system.

### Target System Direction

The long-term development of Resto-POS is centered around a unified platform:

**Customer Ordering → Authentication → Cart → Checkout → Payment → Order Processing → Inventory → POS → Reporting**

This architecture allows the system to function not only as a point-of-sale solution, but also as a **customer-facing restaurant e-commerce platform and centralized restaurant management system**.

---

## Original Concept

This project started as a simple POS system for restaurant order management and evolved into a full restaurant management platform with future plans for online ordering integration.

---
## Contribution

We welcome contributions! Please follow the proper workflow:

1. **Fork the repository**

2. **Create a new branch**

```bash
git checkout -b feature/your-feature-name
```

3. **Make your changes and commit**

```bash
git add .
git commit -m "feat: add new feature"
```

4. **Push your branch**

```bash
git push origin feature/your-feature-name
```

5. **Open a Pull Request**

📌 Please read:

* `CONTRIBUTING.md`
* `CODE_OF_CONDUCT.md`
* `SECURITY.md`

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/devstygian/Resto-POS.git
```

2. Move to XAMPP directory:

```bash
C:\xampp\htdocs\Resto-POS
```

3. Start **Apache** and **MySQL** in XAMPP

4. Import database:

* Open **phpMyAdmin**
* Import: `database/schema.sql`

5. Run the system:

```bash
http://localhost/Resto-POS
```

---

## Project Documentation

This repository includes internal documentation:

* `DOCUMENTATION.md` → Architecture, modules, endpoints, and system logic

Use this to quickly understand the system structure.

---

## Commit Convention

```bash
feat:     new feature
fix:      bug fix
style:    UI / CSS changes
refactor: code improvement (no feature)
chore:    cleanup / minor changes
docs:     documentation
test:     testing
```

---

## Author

**DevStygian**
📧 [hackstygian@gmail.com](mailto:hackstygian@gmail.com)

---

## 📌 Notes

* This project is developed for **educational purposes**
* Not intended for production use without further improvements (security, scaling, validation)

---

⭐ If you find this project useful, feel free to star the repository!
