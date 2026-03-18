![PHP](https://img.shields.io/badge/PHP-7.4-blue) ![MySQL](https://img.shields.io/badge/MySQL-5.7-green) ![License](https://img.shields.io/badge/License-Educational-orange)

# Nadine POS System

**Capstone Project** – A restaurant order and menu management system built using **PHP**, **MySQL**, and **XAMPP**.  
This system allows restaurant staff to manage menus, orders, dashboards, and user authentication efficiently.

---

## Features

- **Menu Management:** Add, edit, and categorize menu items with images.
- **Order Management:** Track, update, and filter orders.
- **Dashboard:** View sales statistics and order summaries.
- **User Authentication:** Secure login system for staff.
- **Security:** Passwords hashed with `password_hash()` and protection against SQL injection.
- **Responsive UI:** Clean interface for easy navigation.

---

## Technologies Used

- **Backend:** PHP, MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Server:** XAMPP
- **Libraries:** Font Awesome for icons

---

## Development Progress

- See the [TODO list](TODO.md) for planned features and improvements
TODO.md
---
## Contribution

If you want to contribute:

1. Create a new branch:
```bash
git checkout -b (branch name/yourname)
```
or Switch to Feature branch 
> Don't work on main branch
```bash
git switch feature
```
2. Make your changes and commit:
```bash
git add .
git commit -m "Describe your feature"
```
3. Push the branch:
```bash
git push -u origin feature-branch
```
4. Open a Pull Request on GitHub.
---
## Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/Nadine-system.git
```
2. Move the project into the XAMPP htdocs folder:
```bash
C:\xampp\htdocs\Nadine-system
```
3. Start Apache and MySQL in XAMPP.

4. Import the database schema (database/schema.sql) into phpMyAdmin.

5. Open the project in your browser:
```bash
http://localhost/Nadine-system
```
---
### Commit Format
```bash
<type>: <short description>

feat: add search functionality to orders page
fix: correct login password hashing issue
style: redesign sidebar logo
refactor: clean up database connection logic
chore: remove unnecessary comments

```
## Author
**Stygian**  
Contact: [hackstygian@gmail.com](mailto:hackstygian@gmail.com)
