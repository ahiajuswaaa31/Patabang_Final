# Patabang - Tutor Matching System

## 📖 About the Project
Patabang is a **web-based tutor matching system** that helps students connect with tutors based on their **MBTI personality type**.  
It features tutor searching, booking management, session tracking, and rating functionalities.

## 🛠 Features
- 📌 **MBTI Test** - Users take a personality test for better tutor matching.  
- 📌 **Tutor Search & Booking** - Students can find and book tutors based on MBTI compatibility.  
- 📌 **Tutor Dashboard** - Tutors manage session requests and schedules.  
- 📌 **Ratings & Reviews** - Users can rate tutors after sessions.  
- 📌 **Admin Panel** - Admins manage users, tutors, and session records.  

---

## 📂 Folder Structure
Patabang/ │── index.php # Homepage │── config.php # Database connection │── styles.css # Main CSS │── header.php # Navigation bar │── footer.php # Footer │── README.md # Documentation (this file) │── assets/ # Static assets (CSS, images, etc.) │── pages/ # All subpages │ ├── login.php # Login Page │ ├── register.php # User Registration │ ├── mbti_test.php # MBTI Personality Test │ ├── tutors.php # List of Tutors │ ├── bookings.php # View/Manage Bookings │ ├── ratings.php # Leave Ratings for Tutors │ ├── profile.php # User Profile │ ├── tutor_dashboard.php# Tutor Management Panel │── admin/ # Admin Panel │ ├── dashboard.php # Admin Dashboard │ ├── manage_users.php # Admin User Management │ ├── manage_tutors.php # Tutor Management │── database/ # SQL Files │ ├── patabang.sql # Database Schema


---

## 🚀 Installation Guide
### **Step 1: Install XAMPP**
1. Download & install **XAMPP** from [Apache Friends](https://www.apachefriends.org/).  
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.  

### **Step 2: Set Up the Database**
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin/`).  
2. Create a new database: `patabang`.  
3. Import `database/patabang.sql`.  

### **Step 3: Configure the System**
1. Open `config.php` and update database credentials if needed:
```php
<?php
$host = "localhost";
$user = "root"; // Change if you have a different user
$password = "";
$database = "patabang";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

http://localhost/patabang/index.php
