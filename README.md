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
## Project Documentation
This repository includes a detailed internal developer and architecture document:
- `DOCUMENTATION.md` (main source for feature explanation, module breakdown, endpoints, and security notes)

Use this file to onboard team members quickly and avoid repeating code walkthroughs.

---
### Commit Format
```bash

| Type       | When to use it                   |
| ---------- | -------------------------------- |
| `feat`     | New feature                      |
| `fix`      | Bug fix                          |
| `style`    | UI / design / CSS                |
| `refactor` | Improve code (no new feature)    |
| `chore`    | Cleanup, comments, minor changes |
| `docs`     | Documentation                    |
| `test`     | Testing                          |


```
## Author
**Stygian**  
Contact: [hackstygian@gmail.com](mailto:hackstygian@gmail.com)
