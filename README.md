# My LAMP Project

This repository contains a project for setting up a LAMP (Linux, Apache, MySQL, PHP) web server on an AWS EC2 instance. The project demonstrates how to configure a basic web server, connect it to a database, and log visitor information. Below are the detailed steps and configurations.

## Table of Contents
1. [Project Overview](#project-overview)
2. [Setup Instructions](#setup-instructions)
3. [Testing the Setup](#testing-the-setup)
4. [Using Git and GitHub](#using-git-and-github)
5. [Networking Basics](#networking-basics)
6. [Links](#links)

---

## Project Overview
The goal of this project is to create a basic website hosted on a Linux server with:
- Apache as the web server.
- MySQL for database management.
- PHP for server-side scripting.

The website also logs visitor IPs and the visit time to a MySQL database.

---

## Setup Instructions

### 1. Launch an AWS EC2 Instance
- **Instance Name**: Choose an appropriate name.
- **Operating System**: Ubuntu Server 24.04 LTS (64-bit).
- **Key Pair**: Create a key pair (e.g., `anassar.pem`) for SSH access.
- **Security Group**: Configure the following:
  - Allow HTTP (Port 80) from `0.0.0.0/0`.
  - Allow SSH (Port 22) from your IP.

### 2. Connect to the Instance
Use the following command to connect to your server:
```bash
ssh -i anassar.pem ubuntu@<your-ec2-instance-public-ip>
```

### 3. Install Required Packages
Run the following commands to install necessary components:
```bash
sudo apt-get update
sudo apt-get install apache2 -y
sudo apt-get install php libapache2-mod-php php-mysql -y
sudo apt-get install mysql-server -y
```

### 4. Verify Installations
- **Apache**: Access `http://<your-ec2-instance-public-ip>` in your browser.
- **PHP**: Create a file `/var/www/html/info.php` with the following content and access it in your browser.
  ```php
  <?php
  phpinfo();
  ?>
  ```
- **MySQL**: Log in to MySQL and list databases:
  ```bash
  sudo mysql -u root -p
  SHOW DATABASES;
  ```

### 5. Configure Apache
Ensure that Apache serves files from `/var/www/html/` by checking its configuration:
```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```
Restart Apache after making changes:
```bash
sudo systemctl restart apache2
```

### 6. Set Up the Website
1. Create a basic `index.html` or `index.php` file in `/var/www/html/`.
2. Example `index.php`:
   ```php
   <?php
   echo "Hello World!";
   ?>
   ```

### 7. Configure MySQL
1. Secure MySQL installation:
   ```bash
   sudo mysql_secure_installation
   ```
2. Create a database and user:
   ```sql
   CREATE DATABASE web_db;
   CREATE USER 'web_user'@'localhost' IDENTIFIED BY 'Nassar@321456#';
   GRANT ALL PRIVILEGES ON web_db.* TO 'web_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

### 8. Update Website to Log Visitors
Modify `index.php` to:
- Connect to MySQL.
- Create a table for visitors.
- Log visitor IPs and timestamps.

Example:
```php
<?php
$servername = "localhost";
$username = "web_user";
$password = "Nassar@321456#";
$dbname = "web_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(50) NOT NULL,
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

$visitor_ip = $_SERVER['REMOTE_ADDR'];
$sql = "INSERT INTO visitors (ip_address) VALUES ('$visitor_ip')";
$conn->query($sql);

echo "Your IP address is: $visitor_ip<br>";
$conn->close();
?>
```

---

## Testing the Setup
1. Access the website: `http://<your-ec2-instance-public-ip>`.
2. Check visitor logs in MySQL:
   ```sql
   USE web_db;
   SELECT * FROM visitors;
   ```

---

## Using Git and GitHub
1. Initialize Git:
   ```bash
   git init
   ```
2. Create a `.gitignore` file:
   ```
   .env
   config.php
   *.log
   ```
3. Add and commit files:
   ```bash
   git add .
   git commit -m "Initial commit"
   ```
4. Link to GitHub repository:
   ```bash
   git remote add origin https://github.com/ain931/my-lamp-project.git
   git push -u origin main
   ```
5. Sync updates:
   ```bash
   git add .
   git commit -m "Update"
   git push
   ```

---

## Networking Basics
- **IP Address**: Identifies a device on a network.
- **MAC Address**: Fixed identifier for a device's network card.
- **Switch**: Connects devices within the same LAN.
- **Router**: Connects different networks.
- **Routing Protocols**: Rules for determining data paths (e.g., OSPF, BGP).

---

## Links
- **Website**: [Visit Website](http://3.85.11.23)
- **GitHub Repository**: [my-lamp-project](https://github.com/ain931/my-lamp-project)

