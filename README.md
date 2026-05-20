# 🎯 ChillSpot Student Activity Hub

**ChillSpot** is an all-in-one student activity hub and campus portal developed for campus coordination. It offers students a seamless way to check campus amenities in real-time, catch up on events, coordinate activities, play mini-games, and communicate with peers. The platform features dynamic global branding, allowing administrators to customize the institute name dynamically from the control panel.

---

## 🌟 Key Features

### 1. 🏷️ Dynamic Global Branding
- **Custom Institute Name**: Admins can change the institute name (originally "CUCEK") globally.
- **Dynamic Text Refactoring**: An integrated DOM-traversing client-side script updates references in headers, footers, paragraphs, and browser tab titles without affecting critical URLs or file directories.

### 2. 🔑 Student Authentication & Profiles
- **Secure Access**: Standard login/signup verification using PHP and MySQL.
- **Detailed Profiles**: Stores registration numbers, departments, years, and profile pictures.
- **Live Presence**: Detects and showcases live user activity status (Online/Offline) on the platform.

### 3. 💬 Peer-to-Peer Chat
- **Direct Messaging**: Connect with other students on campus.
- **Real-Time feel**: Frequent polling to fetch and display messages without manual refresh.
- **Cache-Busting Avatars**: Automatically loads updated profile pictures dynamically.

### 4. ☕ Campus Canteen Portal
- **Menu Display**: Highlights current food availability and pricing.
- **Operating Status**: Visual banner indicating if the canteen is currently *Open* or *Closed*.
- **Admin Control**: Dedicated panel to update status banners, broadcast notices, and revise the menu.

### 5. 📚 Library Assistant
- **Crowd Tracker**: Check real-time crowd density (Low/Medium/High).
- **Seat Availability**: View if the library is fully occupied or has open seats.
- **Notice Board**: Displays official announcements from librarians.
- **Book Registry**: Search available books and check authors/publication years.

### 6. 💻 Lab Facility Manager
- **Live Status**: Displays the current operating status and active activities/practical exams across different computer labs.
- **Crowd Indicator**: Shows the occupancy level of the labs before heading over.

### 7. 🏀 Sports Hub
- **Events Calendar**: Tracks college sports meets, tournaments, and schedules.
- **Live Broadcast**: Notifications and notices about sports activities, selection trials, and venue details.

### 8. 🎉 Events Calendar
- **Campus Events**: Display upcoming workshops, tech fests, seminars, and arts festivals.
- **Instant Alerts**: Notification bar for flash updates.

### 9. 🎮 Online Fun (Arcade Zone)
- **Mini-Games**: Casual games built with Vanilla JavaScript and Canvas:
  - 🐍 **Snake**: Classic retro snake game.
  - 🏓 **Pong**: Responsive table tennis game.
  - 🧱 **Tetris**: Brick stacking puzzle.

---

## 📂 Project Structure

```text
chillspot/
├── admin/                      # Central Admin controls and user management
│   ├── adminlogin.html         # Admin login interface
│   ├── login.php               # Admin credential checker
│   ├── adminmain.html          # Main administrator control panel
│   ├── admin_users.php         # User management grid (CRUD)
│   ├── settings.php            # NEW: System Settings page (Institute Name CRUD)
│   └── user_update.php         # Handler for updating user profile fields
├── chat/                       # Live student chat module
│   ├── chat_module.php         # Chat workspace and user roster interface
│   ├── get_users.php           # Retrieves and formats active student list
│   ├── get_messages.php        # Retrieves message logs for a conversation
│   └── send_message.php        # Handlers for sending new direct messages
├── cucekcanteen/               # Canteen food list and status controls
│   ├── canteenindex.html       # Client menu and status board
│   ├── admincanteen.html       # Canteen admin dashboard
│   └── api.php                 # Canteen data gateway
├── cucekevents/                # College event management
│   ├── events.html             # Student timeline display
│   ├── eventsadmin.html        # Event poster dashboard
│   └── api.php                 # Events database gateway
├── cuceklabs/                  # Labs crowd density tracker
│   ├── labindex.html           # Lab statuses list
│   ├── labadmin.html           # Lab manager control panel
│   └── api.php                 # Lab state management gateway
├── cuceklibrary/               # Library resource manager
│   ├── library.html            # Main student library viewer
│   ├── libraryadmin.html       # Librarian dashboard
│   └── api.php                 # Library data management gateway
├── cuceksportshub/             # Sports tournament tracker
│   ├── sportshub.html          # Sports scheduler & info feed
│   ├── sportshubadmin.html     # Sports manager panel
│   └── api.php                 # Sports database gateway
├── js/                         # Static assets
│   └── institute.js            # NEW: Client-side dynamic text replacement helper
├── uploads/                    # Stores student profile pictures
├── get_institute.php           # NEW: Retrieves institute name settings
├── login.html / login.php      # Main student entrypoint authentication
├── signup.html / signup.php    # Student registration files
├── onlinefun.html              # Mini-game selection lounge
├── snake.html / pong.html...   # Classic HTML5 Canvas game files
├── db.php                      # Root database connection configuration (with auto settings DB creation)
└── README.md                   # Project documentation
```

---

## 🗄️ Database Configurations

ChillSpot utilizes module-specific databases in XAMPP (MySQL) to maintain decoupling. Create the following schemas:

### 1. `chillspot` (Core Auth, Chat, & Settings)
```sql
CREATE DATABASE IF NOT EXISTS chillspot;
USE chillspot;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regno VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    year VARCHAR(10) NOT NULL,
    dept VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    last_active DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT NOT NULL
);

-- Seed Settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('institute_name', 'CUCEK');
```

*(Note: The `settings` table is automatically initialized and seeded by `db.php` if missing.)*

### 2. `chillspot_canteen` (Canteen Menu)
```sql
CREATE DATABASE IF NOT EXISTS chillspot_canteen;
USE chillspot_canteen;

CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

-- Seed Settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('canteenStatus', 'Open'),
('customStatus', 'Serving hot meals until 5 PM!'),
('notification', 'Special biryani available today!');
```

### 3. `cucek_labs` (Lab Availability)
```sql
CREATE DATABASE IF NOT EXISTS cucek_labs;
USE cucek_labs;

CREATE TABLE IF NOT EXISTS labs (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL,
    crowd VARCHAR(50) NOT NULL,
    event VARCHAR(255) DEFAULT ''
);

-- Seed default lab records
INSERT INTO labs (id, name, status, crowd, event) VALUES
('lab_1', 'Main Computer Lab', 'Open', 'Low', 'No Event'),
('lab_2', 'Microprocessor Lab', 'Closed', 'Empty', 'System Maintenance'),
('lab_3', 'Network Lab', 'Open', 'High', 'Internal Practical Exam');
```

### 4. `cucekevents` (Campus Events)
```sql
CREATE DATABASE IF NOT EXISTS cucekevents;
USE cucekevents;

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 5. `librarysystem` (Library & Seating Status)
```sql
CREATE DATABASE IF NOT EXISTS librarysystem;
USE librarysystem;

CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publication_year VARCHAR(10) NOT NULL
);

-- Seed Settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('libraryStatus', 'Open'),
('customLibraryStatus', 'Silence to be maintained.'),
('crowdLevel', 'Medium');
```

### 6. `sports_hub` (Sports Scheduler)
```sql
CREATE DATABASE IF NOT EXISTS sports_hub;
USE sports_hub;

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL
);

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🛠️ Installation & Setup

1. **Clone/Download the Project**:
   Copy the `chillspot` folder to your local server's root web directory (e.g., `C:/xampp/htdocs/chillspot` or `/Applications/XAMPP/xamppfiles/htdocs/chillspot`).

2. **Configure Database**:
   - Start the **Apache** and **MySQL** services via the XAMPP Control Panel.
   - Go to your browser and access `http://localhost/phpmyadmin/`.
   - Run the SQL CREATE statements listed above in the **SQL** tab to initialize the tables and populate default seed values.

3. **Verify Settings**:
   - Check `db.php` in the root and ensure the credentials match your MySQL server configuration (by default, server `localhost`, username `root`, password `""`).

4. **Verify Folder Permissions**:
   - Make sure the `uploads` directory has proper read and write permissions (e.g., `chmod 777 uploads` in macOS/Linux) so profile picture uploads complete successfully.

5. **Start Exploring**:
   - Open your web browser and navigate to `http://localhost/chillspot/login.html`.
   - Register a new student account to gain access to the dashboard.
   - Access the admin panel at `http://localhost/chillspot/admin/adminlogin.html`.
