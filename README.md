# 📝 Simple Todo App

This is a **simple Todo web application** built using **HTML**, **CSS**, and **PHP**. The backend is powered by **MySQL** for storing users and their todo items.

---

## 🚀 Features

* User registration and login system
* Add, edit, and delete todo tasks
* Mark tasks as completed
* Clean and responsive UI

---

## 🛠️ Tech Stack

* **Frontend:** HTML, CSS
* **Backend:** PHP
* **Database:** MySQL
* **Local Server:** XAMPP

---

## 📦 Setup Instructions

Follow these steps to set up and run the project on your local machine:

### 1. ✅ Prerequisites

* [XAMPP](https://www.apachefriends.org/index.html) installed on your computer

### 2. 🚦 Start XAMPP

* Open XAMPP Control Panel
* Start **Apache** and **MySQL**

### 3. 💂️ Project Files

* Place the project folder (e.g., `todo-app`) inside:
  `C:\xampp\htdocs\` (for Windows)
  or
  `/Applications/XAMPP/htdocs/` (for macOS)

### 4. 🛂️ Database Setup

* Open **phpMyAdmin** in your browser:
  [http://localhost/phpmyadmin](http://localhost/phpmyadmin)

* Create a new database named:

  ```
  todo_app
  ```

* Inside this database, create the following tables:

#### Table: `users`

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
);
```

#### Table: `todos`

```sql
CREATE TABLE todos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  is_completed TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
```

> You can also optionally import a `.sql` file if provided in the project folder.

---

## ▶️ Running the App

* Open your browser and navigate to:

  ```
  http://localhost/todo-app
  ```

* Register a new user and start managing your tasks.

---

## 📁 Folder Structure (Example)

```
todo-app/
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── add_todo.php
├── delete_todo.php
├── logout.php
├── css/
│   └── style.css
├── db/
│   └── config.php
```

---

## 💡 Notes

* Make sure your MySQL credentials in `config.php` match your local environment (e.g., username `root` and no password by default in XAMPP).
* Passwords should be hashed using `password_hash()` for security.
* The application uses email during signup and password reset.

---

## 📃 License

This project is for educational purposes and is open for any improvements or customizations.
