-- Database: crud
-- Simple CRUD Database Structure for Books Management System

-- Create database (if needed)
CREATE DATABASE IF NOT EXISTS crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE crud;

-- Create books table
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    type ENUM('Adventure', 'Crime', 'Fantasy', 'Horror') NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO books (title, author, type, description) VALUES
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 'A fantasy novel about a hobbit who embarks on an unexpected journey.'),
('Murder on the Orient Express', 'Agatha Christie', 'Crime', 'A detective story featuring Hercule Poirot solving a murder on a train.'),
('Treasure Island', 'Robert Louis Stevenson', 'Adventure', 'A classic adventure tale of pirates and buried treasure.'),
('Dracula', 'Bram Stoker', 'Horror', 'The classic vampire novel that defined the genre.');

-- Show table structure
DESCRIBE books;

-- Show sample data
SELECT * FROM books;
