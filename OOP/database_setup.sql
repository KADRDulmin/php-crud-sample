-- Database Setup for PHP CRUD OOP Application
-- Run this script to set up the database for the OOP version

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE crud;

-- Drop existing table if it exists (for clean setup)
DROP TABLE IF EXISTS books;

-- Create books table with updated structure
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    type ENUM('Adventure', 'Crime', 'Fantasy', 'Horror') NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Add indexes for better performance
    INDEX idx_title (title),
    INDEX idx_author (author),
    INDEX idx_type (type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB;

-- Insert sample data for testing
INSERT INTO books (title, author, type, description) VALUES
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 
 'A fantasy novel about a hobbit named Bilbo Baggins who embarks on an unexpected journey with a group of dwarves to reclaim their homeland from the dragon Smaug.'),

('Murder on the Orient Express', 'Agatha Christie', 'Crime', 
 'A detective story featuring the famous Belgian detective Hercule Poirot solving a murder that occurs aboard the luxurious Orient Express train.'),

('Treasure Island', 'Robert Louis Stevenson', 'Adventure', 
 'A classic adventure tale of young Jim Hawkins who discovers a treasure map and sets sail with pirates in search of buried treasure on a mysterious island.'),

('Dracula', 'Bram Stoker', 'Horror', 
 'The classic vampire novel that introduced Count Dracula and established many of the conventions of vampire fiction that persist to this day.'),

('The Adventures of Sherlock Holmes', 'Arthur Conan Doyle', 'Crime', 
 'A collection of twelve short stories featuring the brilliant detective Sherlock Holmes and his loyal companion Dr. Watson solving various mysteries.'),

('Journey to the Center of the Earth', 'Jules Verne', 'Adventure', 
 'A science fiction adventure about a German professor and his nephew who discover a passage to the center of the Earth and encounter prehistoric creatures.'),

('The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 
 'An epic high-fantasy novel about the hobbit Frodo Baggins and his quest to destroy the One Ring and save Middle-earth from the Dark Lord Sauron.'),

('Frankenstein', 'Mary Shelley', 'Horror', 
 'A Gothic novel about a young scientist who creates a grotesque creature in an unorthodox scientific experiment, exploring themes of creation and responsibility.');

-- Display table structure for verification
DESCRIBE books;

-- Show sample data
SELECT 
    id,
    title,
    author,
    type,
    SUBSTRING(description, 1, 50) AS description_preview,
    created_at
FROM books 
ORDER BY created_at DESC;

-- Display table statistics
SELECT 
    COUNT(*) as total_books,
    COUNT(DISTINCT author) as unique_authors,
    COUNT(DISTINCT type) as book_types
FROM books;

SELECT 
    type,
    COUNT(*) as count
FROM books 
GROUP BY type 
ORDER BY count DESC;
