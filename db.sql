-- Create the database (if it doesn't already exist)
CREATE DATABASE IF NOT EXISTS tailor_system;

-- Use the database
USE tailor_system;

-- Create the `manager` table for login credentials
CREATE TABLE IF NOT EXISTS manager (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Create the `tailors` table to store tailor details
CREATE TABLE IF NOT EXISTS tailors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone INT(11) NOT NULL,   -- Added phone number column
    address VARCHAR(255) NOT NULL, -- Added address column
    current_compensation DECIMAL(10, 2) DEFAULT 0.00
);

-- Create the `outputs` table to store the fabric outputs and quantities
CREATE TABLE IF NOT EXISTS outputs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tailor_id INT,
    output_type VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (tailor_id) REFERENCES tailors(id) ON DELETE CASCADE
);

-- Create the `fabric_inventory` table to store fabric details
CREATE TABLE IF NOT EXISTS fabric_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    color VARCHAR(255) NOT NULL
);
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tailor_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    date_paid DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tailor_id) REFERENCES tailors(id)
);

CREATE TABLE compensation_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tailor_id INT NOT NULL,
    output_type VARCHAR(100),
    quantity INT,
    total_compensation DECIMAL(10, 2),
    FOREIGN KEY (tailor_id) REFERENCES tailors(id)
);
