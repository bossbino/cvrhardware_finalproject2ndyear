CREATE DATABASE IF NOT EXISTS cvr_hardware;
USE cvr_hardware;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100),
    role ENUM('admin','customer') NOT NULL
);

INSERT INTO users (username,password,fullname,role) VALUES
('noveneil','admin123','Noveneil Admin','admin'),
('customer1','customer123','Customer One','customer');

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    quantity INT,
    image VARCHAR(255)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    status ENUM('Pending','Accepted','Delivered') DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
