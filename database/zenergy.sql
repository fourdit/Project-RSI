-- Database: zenergy
CREATE DATABASE IF NOT EXISTS zenergy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE zenergy;

-- Table: users (Laravel default + custom fields)
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    domisili VARCHAR(255) NULL,
    profile_photo_path VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: electricity_notes
CREATE TABLE electricity_notes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    price_per_kwh DECIMAL(10,2) NOT NULL,
    house_power INT NOT NULL,
    total_cost DECIMAL(12,2) DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: electricity_items
CREATE TABLE electricity_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    note_id BIGINT UNSIGNED NOT NULL,
    appliance_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    duration_hours INT NOT NULL,
    duration_minutes INT NOT NULL,
    wattage INT NOT NULL,
    cost DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (note_id) REFERENCES electricity_notes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;