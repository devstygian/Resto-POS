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

## Development Timeline

#### Phase 1 – Planning
- Defined system scope as a Restaurant Management System
- Selected technology stack: PHP, MySQL, XAMPP
- Designed initial database structure and UI concept

#### Phase 2 – Core System Development
- Built authentication system (login/logout with roles)
- Developed admin and staff dashboard
- Implemented menu and order management modules

#### Phase 3 – Database Integration
- Connected system to MySQL database
- Implemented CRUD operations for menu, orders, and users

#### Phase 4 – UI & Feature Improvements
- Improved dashboard layout and usability
- Added reporting and order tracking features
- Enhanced responsiveness and UI consistency

#### Phase 5 – Expansion Plan
- Planned integration of online ordering system (web-based landing page)
- Future goal: unify POS system with customer-facing ordering platform

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
