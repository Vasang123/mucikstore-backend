-- MucikStore Database Setup
-- Run this file once to create the database, tables, and seed data.

CREATE DATABASE IF NOT EXISTS mucikstore
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE mucikstore;

-- -------------------------------------------------------
-- Users table
-- user_role: 'admin' | 'user'
-- Passwords stored as plain text here to match the app's
-- login flow (app sends raw password, server compares directly).
-- Change to hashed passwords in any real deployment.
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    user_id       INT          NOT NULL AUTO_INCREMENT,
    user_email    VARCHAR(255) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    user_role     ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------
-- Products table
-- uploaded_by references the user who added the product.
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS products (
    item_id     INT          NOT NULL AUTO_INCREMENT,
    item_name   VARCHAR(255) NOT NULL,
    item_weight INT          NOT NULL DEFAULT 0,
    item_price  INT          NOT NULL DEFAULT 0,
    uploaded_by INT,
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (item_id),
    CONSTRAINT fk_uploaded_by FOREIGN KEY (uploaded_by)
        REFERENCES users (user_id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------
-- Seed data
-- -------------------------------------------------------

-- Admin account  (email: admin@mucikstore.com  password: admin123)
-- User account   (email: user@mucikstore.com   password: user123)
INSERT INTO users (user_email, user_password, user_role) VALUES
    ('admin@mucikstore.com', 'admin123', 'admin'),
    ('user@mucikstore.com',  'user123',  'user');

-- Sample products uploaded by user id=2 (the regular user)
INSERT INTO products (item_name, item_weight, item_price, uploaded_by) VALUES
    ('Gitar Akustik Yamaha F310', 2500, 1500000, 2),
    ('Bass Elektrik Squier',      3200, 2800000, 2),
    ('Drum Pad Roland SPD-SX',    1800,  950000, 2),
    ('Keyboard Casio CT-X700',    3500, 1200000, 2);
