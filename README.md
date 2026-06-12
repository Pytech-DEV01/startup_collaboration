# Startup Collaboration Portal 🚀

A full-stack mini Database Management System project built with PHP, MySQL, and modern HTML/CSS/JS.

## Features
- **Modern UI**: Dark theme, glassmorphism, responsive grid layout, micro-animations.
- **Dynamic Frontend**: AJAX-powered, no page reloads, toast notifications, dynamic DOM updates.
- **Robust Backend**: Core PHP API layer separating routing and logic.
- **Complex Database**: 15 normalized tables, proper foreign keys, structured relationships.

---

## 🛠️ Setup Instructions (XAMPP)

Follow these exact steps to run the project on your machine:

### 1. Start XAMPP
Open the XAMPP Control Panel and start **Apache** and **MySQL**.
*(Ensure MySQL is running on your configured port, which is 3307 based on `db.php`).*

### 2. Copy to htdocs
Copy this entire `startup-portal` folder into your XAMPP `htdocs` directory.
- Usually located at: `C:\xampp\htdocs\`
- Your folder structure should look like: `C:\xampp\htdocs\startup-portal\index.php`

### 3. Create Database & Import SQL
1. Open your browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) (or `http://localhost:3307/phpmyadmin` if you access it via a specific port).
2. Click **New** on the left sidebar to create a database.
3. Name it exactly: `startup_portal`
4. Click **Create**.
5. Select the newly created `startup_portal` database.
6. Click the **Import** tab at the top.
7. Click **Choose File** and select the `database.sql` file located in this folder.
8. Scroll down and click **Import** (or "Go").
9. Wait for the success message. This will create all 15 tables and populate them with over 80 records of realistic sample data.

### 4. Run the Project
Open your browser and navigate to:
[http://localhost/startup-portal/FrontEnd/](http://localhost/startup-portal/FrontEnd/)

---

## 📁 Folder Structure Explained

```text
/startup-portal
├── FrontEnd/                      # Frontend root directory
│   ├── index.php                  # Main Dashboard page
│   ├── welcome.php                # Welcome / landing page
│   │
│   ├── /assets/                   # Frontend assets
│   │   ├── style.css              # Main modern dark theme styles
│   │   ├── dashboard.css          # Dashboard-specific layout styles
│   │   ├── forms.css              # Modal and form styling
│   │   ├── script.js              # All AJAX, dynamic DOM, and UI logic
│   │   └── steve_jobs.jpg         # Welcome page image
│   │
│   ├── /pages/                    # Application sections
│   │   ├── startups.php           # Startups directory & management
│   │   ├── events.php             # Event listings & creation
│   │   ├── investors.php          # Investor tracking
│   │   ├── organizations.php      # Universities & incubators
│   │   ├── applications.php       # Join/invest applications
│   │   ├── mentorships.php        # Mentor-mentee connections
│   │   └── participants.php       # Event registration tracking
│   │
│   └── /includes/                 # Reusable UI components
│       ├── header.php             # Shared navigation & sidebar
│       └── footer.php             # Shared footer & scripts
│
├── /api/                          # PHP Backend Layer (JSON responses)
│   ├── fetch.php                  # Handles all SELECT/GET queries
│   ├── insert.php                 # Handles all INSERT/POST queries
│   ├── update.php                 # Handles all UPDATE operations
│   ├── delete.php                 # Handles all DELETE operations
│   └── register.php               # Specialized event registration logic
│
├── db.php                         # Database connection configuration
├── database.sql                   # Full schema + sample data (15 tables)
├── Dockerfile                     # Docker build configuration
├── README.md                      # Project documentation
└── Project_Report.md              # Project report
```

---

## ⚡ How the System Works (Architecture)

1. **Frontend to Backend (AJAX)**
   - When you visit a page (e.g., Startups), `script.js` fires an asynchronous `fetch()` request to `/api/fetch.php?type=startups`.
   - The page loads instantly without waiting for the database, showing a loading state or skeleton.

2. **Backend to Database (PHP + MySQLi)**
   - `fetch.php` includes `db.php` to connect to MySQL (port 3307).
   - It runs a complex `SELECT` query with `JOIN`s (e.g., joining startups with their types and founders).
   - The result is fetched as an associative array and encoded into JSON.

3. **Backend to Frontend (JSON)**
   - The JSON is returned to `script.js`.
   - JavaScript dynamically generates HTML cards (`<div class="card">...</div>`) and injects them into the DOM.
   - If you submit a form (e.g., "Add Startup"), JS prevents the default page reload, sends the data via POST to `/api/insert.php`, and upon success, shows a toast notification and re-fetches the list seamlessly.

Enjoy building your Startup Ecosystem!
