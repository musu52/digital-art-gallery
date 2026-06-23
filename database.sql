CREATE DATABASE art_gallery;
USE art_gallery;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    address TEXT NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    profile_pic VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    password VARCHAR(100)
);
INSERT INTO admin (email, password) 
VALUES ('admin@gmail.com', '1234');

CREATE TABLE paintings(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    price INT,
    cost INT,
    image VARCHAR(255)
);

CREATE TABLE cart(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT
);
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    painting VARCHAR(100),
    total INT,
    status VARCHAR(20) DEFAULT 'Pending',
    phone VARCHAR(20),
    address TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reviews(
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    name VARCHAR(100),
    rating INT,
    comment TEXT
);
