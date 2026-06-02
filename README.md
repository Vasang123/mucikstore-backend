# MucikStore Backend - Recreated 

PHP + MySQL for the MucikStore Android app. Runs on plain HTTP (no SSL). This version of backend only run with the apk provided in this repo. 

---

## Prerequisites

| Tool | Version | Download |
|------|---------|----------|
| PHP  | 7.4+    | https://windows.php.net/download/ (or via XAMPP) |
| MySQL / MariaDB | 5.7+ / 10.3+ | https://dev.mysql.com/downloads/ (or via XAMPP) |

> **Easiest option on Windows:** [XAMPP](https://www.apachefriends.org/) — ships PHP + MariaDB together.

---

## 1. Database Setup

### Option A — using the MySQL CLI

```bash
mysql -u root -p < database/setup.sql
```

### Option B — using phpMyAdmin (XAMPP)

1. Open `http://localhost/phpmyadmin`
2. Click **Import**
3. Choose `database/setup.sql` and click **Go**

This creates the `mucikstore` database with two tables and some seed data.

---

## 2. Configure the Database Connection

Edit `config/database.php` and set your credentials:

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'mucikstore');
define('DB_USER', 'root');   // change if needed
define('DB_PASS', '');        // change if needed
```

---

## 3. Run the Server

Open a terminal in the `mucikstore-backend` folder and run:

```bash
php -S 0.0.0.0:1234
```

The server starts immediately. No Apache/Nginx needed.

- Access from the same machine: `http://localhost:1234`
- Access from the Android device/emulator: `http://10.0.2.2:1234`


---

## 4. Connect the Android App

When the MucikStore app launches it shows an **Enter IP** screen. Type your PC's local IP or android studio loopback ip:

> Make sure your Android device and PC are on the **same network**, or use: `10.0.2.2` if the backend is in the same PC.
---

## 5. Seed Accounts

| Email | Password | Role |
|-------|----------|------|
| admin@mucikstore.com | admin123 | admin |
| user@mucikstore.com  | user123  | user  |

---

## API Reference

All responses are plain text or JSON. No authentication headers required.

### `POST /getUser.php`
Validates login credentials.

| Param | Type | Description |
|-------|------|-------------|
| `user_email` | string | User's email address |
| `user_password` | string | User's password |

**Response — success:**
```json
[{"user_id":"1","user_email":"user@mucikstore.com","user_password":"user123","user_role":"user"}]
```
**Response — not found:**
```
0 results
```

---

### `GET /getProduct.php?user_id=&user_role=`
Returns products. Admins see all products; regular users see only their own.

| Param | Type | Description |
|-------|------|-------------|
| `user_id` | int | Logged-in user's ID |
| `user_role` | string | `admin` or `user` |

**Response:**
```json
[
  {"item_id":"1","item_name":"Gitar Akustik","item_weight":"2500","item_price":"1500000","uploaded_by":"2"}
]
```

---

### `POST /insertProduct.php`
Adds a new product.

| Param | Type | Description |
|-------|------|-------------|
| `prod_name` | string | Product name |
| `prod_weight` | int | Weight in grams |
| `prod_price` | int | Price in IDR |
| `uploaded_by` | int | Logged-in user's ID |

**Response:** `success` or `error: ...`

---

### `POST /updateProduct.php`
Updates an existing product.

| Param | Type | Description |
|-------|------|-------------|
| `prod_id` | int | Product ID to update |
| `prod_name` | string | New name |
| `prod_weight` | int | New weight |
| `prod_price` | int | New price |

**Response:** `success` or `error: ...`

---

### `GET /deleteProduct.php?prod_id=`
Deletes a product by ID.

| Param | Type | Description |
|-------|------|-------------|
| `prod_id` | int | Product ID to delete |

**Response:** `success` or `error: ...`

---

### `GET /getProductReportForAdmin.php`
Returns total product and user counts (used by the app at startup).

**Response:**
```json
["4", "2"]
```
Index 0 = total products, Index 1 = total users.

---

## Project Structure

```
mucikstore-backend/
├── config/
│   └── database.php        # DB credentials and shared headers
├── database/
│   └── setup.sql           # Creates DB, tables, and seed data
├── getUser.php
├── getProduct.php
├── insertProduct.php
├── updateProduct.php
├── deleteProduct.php
├── getProductReportForAdmin.php
└── README.md
```

---

## Troubleshooting

**"Network error, check your IP/server"** in the app
- Confirm the PHP server is running (`php -S 0.0.0.0:1234`)
- Confirm your device and PC are on the same Wi-Fi
- Check Windows Firewall: allow inbound TCP on port 1234

**"Database connection failed"**
- Confirm MySQL/MariaDB is running
- Double-check credentials in `config/database.php`

**Emulator can't connect**
- Use IP `10.0.2.2` instead of `localhost` or `127.0.0.1`
