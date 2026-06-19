# 🔍 Lost and Found Management System

> 🎓 ACADEMIC PROJECT - EDUCATIONAL USE ONLY
>
> Copyright © 2026 K.M Sharfuddin. All Rights Reserved.

![Project Status](https://img.shields.io/badge/Status-Active-success)
![Language](https://img.shields.io/badge/Language-PHP-blue)
![Database](https://img.shields.io/badge/Database-MySQL-orange)
![Environment](https://img.shields.io/badge/Environment-XAMPP-red)

---

## 📝 Project Overview
The **Lost and Found Management System** is a web-based portal developed in PHP to streamline the process of reporting lost items and claiming found items within a community or campus. It provides an organized, automated way for users and administrators to keep track of missing belongings.

---

## 📜 Important Notice

This is an **academic project** created strictly for educational and portfolio purposes.

### ✅ You CAN:
* 👁️ **View and study the code:** Feel free to examine the core script implementation and database design.
* 🛠️ **Modify for personal learning:** You can clone, play around with the code, and improve your backend development skills.
* 🎓 **Reference with attribution:** You are welcome to use this as a learning resource for university assignments, provided you give proper credit.

### ❌ You CANNOT:
* 💰 **Use for commercial purposes:** This project cannot be sold, licensed, or used for any commercial or monetary gains.
* 📋 **Copy and claim as your own:** Do not republish this complete system under your own name or brand.
* 🎓 **Submit directly for academic evaluation:** Do not submit this code as-is for your academic lab/project evaluations to avoid plagiarism.

---

## 🔒 Security & Data Notice

> ⚠️ **Important Note on Data Storage:**
> This system currently utilizes a localized data storage approach. System records, logs, and generated user information are handled and tracked via individual structural records stored inside the static `data/` directory (e.g., `data/reports.txt` and `data/users.txt`). Ensure proper directory permissions (`CHMOD 755` or equivalent) when hosting locally.

---

## 🛠️ Tech Stack

### Backend & Core Logic:
* **PHP** (Core scripting, authentication, and state rendering)

### Storage & Schema:
* **MySQL** (Relational Database management)
* **Flat File Logging** (Backup data files located inside the `data/` folder)

### Frontend Layout:
* **HTML5** & **CSS3** (Structuring via `style.css` and views)
* **JavaScript** (Client-side interactive handling)

---

## 📂 Repository Structure & Architecture

A quick breakdown of the core files included in this system:

```bash
├── data/                 # Directory containing internal system flat logs
│   ├── reports.txt       # Local file tracking generated item reports
│   └── users.txt         # Local backup record of system users
├── admin.php             # Administrative control dashboard panel
├── approve.php           # Claim verification and item status authorization module
├── cancel.php            # Request rollback or reporting cancellation handling
├── dashboard.php         # User centralized activity control center
├── delete_user.php       # Administrative utility for user account cleanup
├── index.php             # Core landing gateway and portal index
├── login.php             # Secure token authentication access point
├── logout.php            # Session clearance module
├── register.php          # Account initialization and sign-up execution
├── report.html           # Simple UI interface for filing a discovery/loss report
├── report.txt            # Local validation/temporary item schema file
├── returned.php          # View archive documenting successfully resolved/returned items
├── save.php              # Dynamic data capture script processing incoming web requests
├── style.css             # Unified global presentation and formatting styles
├── users.php             # Admin view to manage total active community accounts
├── users.txt             # Flat backup index schema
└── view.php              # Publicly queryable grid display for lost & found listings
```
----
⚙️ How to Run
----
Follow these steps carefully to set up and run the project on your local machine.

📋 Prerequisites
---
Make sure you have XAMPP Control Panel installed on your system.

🛠️ Step 1 — Clone the Repository
---
Download or clone this repository into your XAMPP's htdocs directory:

Bash
```cd C:\xampp\htdocs\
git clone [https://github.com/YOUR_GITHUB_USERNAME/Lost-and-Found-Managment-System.git](https://github.com/YOUR_GITHUB_USERNAME/Lost-and-Found-Managment-System.git)
(Note: Replace YOUR_GITHUB_USERNAME with your actual GitHub username).
```

🔌 Step 2 — Start XAMPP
---
Open your XAMPP Control Panel and start both Apache and MySQL services.

🗄️ Step 3 — Set Up the MySQL Database
--
Open your browser and go to: http://localhost/phpmyadmin/

Create a new database named: lost_found_db

Click on the Import tab at the top.

Select the .sql database file provided in this repository and click Go or Import.

⚙️ Step 4 — Database Configuration
---
Inside your project folder, make sure your database connection file (e.g., config.php or db.php) matches your local MySQL credentials:

```PHP
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "lost_found_db";
```
🌐 Step 5 — Run the Application
---
Now, open your web browser and navigate to the application:
```
🌐 App URL: http://localhost/Lost-and-Found-Managment-System/index.php
```
---

## ✨ Features


### 👤 User Features
* **🔒 Secure Authentication:** User registration (`register.php`) and login/logout handling (`login.php`, `logout.php`) to secure user accounts.
* **📋 Personalized Dashboard:** A centralized space (`dashboard.php`) where logged-in users can manage their interactions.
* **📝 Report Management:** Users can dynamically submit forms (`report.html`, `save.php`) to report either lost belongings or items they have found.
* **🔍 Item Grid View:** A public or user-accessible dashboard (`view.php`) to browse active listings of lost and found records.

### 🤖 Intelligent Matching Feature (New)
* **🎯 Automated Keyword Matching:** The system automatically cross-references newly reported lost items against the found items database.
* **📊 Similarity Percentage (%):** Calculates and displays a precise match confidence percentage (%) based on item attributes (titles, categories, or descriptions) to help users identify potential matches instantly.

### 👑 Admin Features
* **🛡️ Centralized Admin Panel:** Dedicated portal (`admin.php`) for community administrators to oversee total system activity.
* **👥 Account Supervision:** Admin tool (`users.php`, `delete_user.php`) to manage registered profiles and ensure network security.
* **✅ Claim & Item Authorization:** Quick controls (`approve.php`, `cancel.php`) to verify user claims or rollback incorrect items.
* **📦 Resolved Archive:** A specialized tracking module (`returned.php`) that documents and logs items successfully matched and returned to their owners.
---

# 🔍 Lost and Found Management System

A dynamic, secure, and user-friendly web application developed with **PHP**, **MySQL**, and **Bootstrap**. This platform is strategically designed to help users efficiently report, track, and recover lost or found items within an organization or university campus ecosystem.

---

## 📸 System Walkthrough & Screenshots

Here is the exact step-by-step visual workflow of the system, showcasing the user-end journey, reporting lifecycle, and centralized administrative backend panel.

### 🔐 Part 1: User Portal & Authentication

#### 1. User Authentication (Login & Registration)
The main secure entry gateway for standard users. It handles authentication sessions and allows new users to register securely into the database.
![User Authentication](Screenshots/WhatsApp%20Image%202026-06-08%20at%202.11.39%20AM.jpeg)

#### 2. User Workspace / Dashboard
Once authenticated, users land on this optimized workspace. It highlights primary navigation pathways, platform summary tiles, and quick shortcuts for tracking.
![User Dashboard](Screenshots/WhatsApp%20Image%202026-05-19%20at%202.39.14%20AM.jpeg)

#### 3. Item Logging & Registration (Upper Interface)
An intuitive, structured multi-field form designed for lodging explicit item parameters, including transaction types (Lost/Found), categories, and precise timestamps.
![Report Form Top](Screenshots/WhatsApp%20Image%202026-06-08%20at%202.11.40%20AM.jpeg)

#### 4. Contact Registry & Media Upload (Lower Interface)
The final segment of the submission module, allowing users to upload binary image assets of the item and attach verified contact data before pushing it live.
![Report Form Bottom](Screenshots/WhatsApp%20Image%202026-06-08%20at%202.11.41%20AM.jpeg)

#### 5. Public Reports Feed (Global Listings)
A unified dynamic feed rendering all unresolved items across the platform. This module allows open browsing for users searching for matches with clear thumbnail previews.
![All Active Reports](Screenshots/WhatsApp%20Image%202026-06-08%20at%202.11.41%20AM%20(1).jpeg)

#### 6. Categorized Grid Search Array
An optimized search grid displaying filtered relational datasets based on individual category selection tags without breaking layout uniformity.
![Filtered View](Screenshots/WhatsApp%20Image%202026-05-19%20at%202.39.15%20AM%20(1).jpeg)

#### 7. Verification & Owner Match Portal
The explicit single-item display layer where claimants can view high-resolution specifications, crosscheck tags, and initiate direct recovery claims.
![Claim Management](Screenshots/WhatsApp%20Image%202026-05-19%20at%202.39.15%20AM%20(3).jpeg)

---

### 👑 Part 2: Administrative Backend Control

#### 8. Secured Admin Gateway
An independent and heavily protected authentication gateway completely isolated from public routing, reserved exclusively for system operators.
![Admin Authentication](Screenshots/WhatsApp%20Image%202026-06-08%20at%202.11.42%20AM.jpeg)

#### 9. Centralized Administration Control Center
The main system control room for admins, featuring automated counter widgets that display concurrent session counts, database volume, and system metrics.
![Admin Central Control Panel](Screenshots/WhatsApp%20Image%202026-06-08%20at%202.11.39%20AM%20(1).jpeg)

#### 10. Admin Master Data Records Management
An advanced administrative ledger panel used by operators to audit submissions, review user details, or drop fraudulent reports.
![Admin Reports Control](Screenshots/WhatsApp%20Image%202026-05-19%20at%202.39.15%20AM%20(4).jpeg)

#### 11. User Account Monitor & Database Logs
A back-end supervisor console for maintaining global database states, observing system infrastructure health, and configuring platform variables.
![User Control Panel](Screenshots/WhatsApp%20Image%202026-05-19%20at%202.39.30%20AM.jpeg)

---

## 🛠️ Core Engineering Features
* **Role-Based Session Guard:** Secured segregation between standard Users and Admins using raw PHP session handling.
* **Structured Relational Database Schema:** Optimized MySQL tables mapping specific data fields for item parameters, paths, and user tables.
* **Modern Interface Layout:** Completely built on Bootstrap responsive layouts with custom layout blocks for premium UX.
