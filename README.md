# ⚡ ExploitInject — Premium Finance Intelligence Dashboard

![ExploitInject Banner](https://img.shields.io/badge/Status-Operational-emerald?style=for-the-badge&logo=opsgenie)
![ExploitInject Branding](https://img.shields.io/badge/Team-ExploitInject-6366F1?style=for-the-badge)

A world-class **Fintech + Cybersecurity SaaS** dashboard built for elite teams. **ExploitInject** provides a secured, high-performance ledger system for real-time revenue tracking, automated profit distribution, and intelligence logging.

---

## 🌑 The Premium "Cyber-Fintech" Aesthetic

ExploitInject features a custom-engineered UI designed for depth, clarity, and authority:
- **Primary Design**: Deep Navy-Black (`#0A0F1C`) with Slate accents.
- **Glassmorphism**: High-blur `backdrop-filter` interface components.
- **Micro-Interactions**: Smooth `1.02x` scaling and glowing hover states.
- **Consensus Facade**: A high-contrast, cybersecurity-inspired landing page for public network traffic.

## 🚀 Core Intelligence Protocols

- **⚡ Automated Consensus**: Instantly splits incoming revenue into **Startup Capital**, **Member Pool**, and **Execution Flow** based on Admin-defined logic.
- **📑 Intelligence Chronicles**: A persistent, real-time notification system (`Shared/notifications.php`) that logs every financial movement and support inquiry.
- **🛡️ SEC-Audit Filter**: Advanced administrative tool for transaction auditing with instant CSV export capabilities.
- **🧩 Secure Support Node**: End-to-end communication channel for members to request protocol adjustments or support.

## 🛠️ Technology Stack

- **Engine**: Core PHP 8.x (MVC Architecture / OOP)
- **Database**: MySQL (PDO / Prepared Statements / Performance Indices)
- **Styling**: Vanilla CSS + Tailwind Core (Deep Navy Tokens)
- **Visualization**: Chart.js 4.0 (Custom Gradient Fills & Soft-Glow Tooltips)
- **Iconography**: Lucide Retina Icons

## ⚙️ Deployment & Setup

### 1. Database Initialization
ExploitInject uses a master initialization script for one-click deployment:
- Create a MySQL database named `finject`.
- Import the [main.sql](file:///e:/xampp/htdocs/Finject/main.sql) file located in the root directory.

### 2. Configuration
Update your environment credentials in `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'finject');
define('DB_USER', 'your_user');
define('DB_PASS', 'your_pass');
```

### 3. Authorized Access
The system initializes with two default identities:

| Role | Identity | Master Key |
| :--- | :--- | :--- |
| **System Admin** | `admin@finject.com` | `t@nim.@dmin` |
| **Team Member** | `user@finject.com` | `password` |

> [!CAUTION]
> All encryption hashes and credentials should be rotated immediately upon deployment via the **Security Settings** panel.

---

---

## 📂 Protocol Architecture

The ExploitInject system is architected following the **MVC (Model-View-Controller)** pattern, ensuring absolute separation of intelligence, logic, and interface.

```text
FINJECT/
├── 📁 Secret
│   ├── 🐘 fix_admin.php
│   ├── 🐘 fix_db_migration.php
│   └── 🐘 fix_user.php
├── 📁 assets
│   ├── 📁 css
│   │   └── 🎨 style.css
│   ├── 📁 img
│   │   ├── 🖼️ favicon_admin.png
│   │   ├── 🖼️ favicon_main.png
│   │   └── 🖼️ favicon_user.png
│   └── 📁 js
│       └── 📄 realtime.js
├── 📁 config
│   └── 🐘 database.php
├── 📁 controllers
│   ├── 🐘 AdminController.php
│   ├── 🐘 AuthController.php
│   ├── 🐘 IncomeController.php
│   ├── 🐘 SharedController.php
│   └── 🐘 UserController.php
├── 📁 helpers
│   └── 🐘 functions.php
├── 📁 models
│   ├── 🐘 Distribution.php
│   ├── 🐘 Income.php
│   ├── 🐘 Notification.php
│   ├── 🐘 SupportRequest.php
│   ├── 🐘 Tool.php
│   └── 🐘 User.php
├── 📁 vendor
├── 📁 views
│   ├── 📁 admin
│   │   ├── 🐘 dashboard.php
│   │   ├── 🐘 income.php
│   │   ├── 🐘 manage_clients_data.php
│   │   ├── 🐘 manage_tutorials.php
│   │   ├── 🐘 requests.php
│   │   ├── 🐘 settings.php
│   │   ├── 🐘 transactions.php
│   │   └── 🐘 users.php
│   ├── 📁 shared
│   │   ├── 🐘 footer.php
│   │   ├── 🐘 header.php
│   │   ├── 🐘 income_modal.php
│   │   ├── 🐘 notifications.php
│   │   └── 🐘 sidebar.php
│   ├── 📁 user
│   │   ├── 🐘 clients.php
│   │   ├── 🐘 clients_data.php
│   │   ├── 🐘 dashboard.php
│   │   ├── 🐘 history.php
│   │   ├── 🐘 support.php
│   │   ├── 🐘 tools.php
│   │   └── 🐘 tutorials.php
│   ├── 🐘 home.php
│   ├── 🐘 login.php
│   └── 🐘 register.php
├── ⚙️ .htaccess
├── 📝 README.md
├── 📄 finject_full.sql
└── 🐘 index.php
```

---
Built with absolute integrity by **Team ExploitInject**
