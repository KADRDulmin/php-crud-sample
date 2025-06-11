# PHP CRUD Book Management System - OOP Version

## Overview
This is a complete Object-Oriented Programming (OOP) implementation of a CRUD (Create, Read, Update, Delete) application for managing books. The application demonstrates fundamental OOP concepts and follows modern PHP development practices.

## OOP Concepts Implemented

### 1. **ENCAPSULATION**
- **Private Properties**: All class properties are private, preventing direct access from outside the class
- **Getter/Setter Methods**: Controlled access to object properties through public methods
- **Data Hiding**: Internal implementation details are hidden from other classes

**Example in Book Model:**
```php
private $title;  // Private property - data hiding

public function getTitle() {  // Controlled access
    return $this->title;
}

public function setTitle($title) {  // Validation before setting
    if ($this->validateTitle($title)) {
        $this->title = trim($title);
    } else {
        throw new InvalidArgumentException("Invalid title");
    }
}
```

### 2. **ABSTRACTION**
- **Interface Simplification**: Complex database operations are simplified into easy-to-use methods
- **Implementation Hiding**: Users don't need to know how data is stored or retrieved

**Example in Repository:**
```php
public function create(Book $book) {
    // Complex SQL logic is hidden
    // User just calls: $repository->create($book);
}
```

### 3. **SINGLE RESPONSIBILITY PRINCIPLE**
- **Database Class**: Only handles database connections
- **Book Model**: Only represents book data and validation
- **Repository**: Only handles data persistence
- **Controller**: Only handles HTTP requests and responses
- **View**: Only handles presentation logic

### 4. **DEPENDENCY INJECTION**
- Controllers receive their dependencies through constructor
- Promotes loose coupling between classes
- Makes testing easier

**Example:**
```php
class BookController {
    private $bookRepository;
    
    public function __construct() {
        $this->bookRepository = new BookRepository(); // Dependency injection
    }
}
```

### 5. **SINGLETON PATTERN**
- Database connection uses Singleton pattern
- Ensures only one database connection exists
- Prevents resource waste

**Example:**
```php
private static $instance = null;

public static function getInstance() {
    if (self::$instance === null) {
        self::$instance = new self();
    }
    return self::$instance;
}
```

### 6. **MVC (Model-View-Controller) PATTERN**
- **Model (Book)**: Represents data and business logic
- **View (BookView)**: Handles presentation and user interface
- **Controller (BookController)**: Manages user input and coordinates between Model and View

### 7. **REPOSITORY PATTERN**
- Encapsulates data access logic
- Provides a uniform interface for data operations
- Makes the application database-agnostic

### 8. **AUTOLOADING**
- Automatically loads classes when needed
- Follows PSR-4 standards
- Eliminates manual require/include statements

### 9. **NAMESPACES**
- Organizes code into logical groups
- Prevents naming conflicts
- Improves code readability

### 10. **ERROR HANDLING**
- Proper exception handling throughout the application
- Custom error messages for different scenarios
- Graceful error recovery

## Project Structure

```
OOP/
├── config/
│   └── Database.php          # Database connection (Singleton pattern)
├── models/
│   └── Book.php             # Book entity (Encapsulation, Validation)
├── repositories/
│   └── BookRepository.php   # Data access layer (Repository pattern)
├── controllers/
│   └── BookController.php   # Request handling (MVC Controller)
├── views/
│   └── BookView.php         # Presentation layer (MVC View)
├── autoload.php             # PSR-4 Autoloader
├── index.php               # Main page - Book listing
├── create.php              # Create new book
├── edit.php                # Edit book form
├── update.php              # Process book updates
├── view.php                # View book details
├── delete.php              # Delete book
├── search.php              # Search books
└── README.md               # This documentation
```

## Features

### Core CRUD Operations
1. **Create**: Add new books with validation
2. **Read**: View all books or individual book details
3. **Update**: Edit existing book information
4. **Delete**: Remove books with confirmation

### Additional Features
1. **Search**: Search books by title or author
2. **Validation**: Input validation and error handling
3. **Flash Messages**: Success/error message system
4. **Responsive UI**: Bootstrap-based modern interface
5. **Security**: SQL injection prevention using prepared statements

## Database Schema

```sql
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    type ENUM('Adventure', 'Crime', 'Fantasy', 'Horror') NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Setup Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server
- Composer (optional, for advanced dependency management)

### Installation Steps

1. **Database Setup**
   ```sql
   -- Create database
   CREATE DATABASE crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   
   -- Use the database
   USE crud;
   
   -- Create books table
   CREATE TABLE books (
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
   ```

2. **Configure Database Connection**
   - Edit `config/Database.php`
   - Update database credentials:
     ```php
     private $host = "localhost";
     private $username = "root";  // Your MySQL username
     private $password = "";      // Your MySQL password
     private $database = "crud";
     ```

3. **Web Server Setup**
   
   **Option A: PHP Built-in Server (Recommended for development)**
   ```bash
   cd /path/to/php-crud-sample/OOP
   php -S localhost:8000
   ```
   Then visit: http://localhost:8000

   **Option B: Apache/Nginx**
   - Place the OOP folder in your web server's document root
   - Access via: http://localhost/OOP

## How to Run

### Method 1: PHP Built-in Server
1. Open Command Prompt/Terminal
2. Navigate to the OOP directory:
   ```bash
   cd "C:\Users\DELL\Documents\Projects\php-crud-sample\OOP"
   ```
3. Start the PHP server:
   ```bash
   php -S localhost:8000
   ```
4. Open browser and go to: http://localhost:8000

### Method 2: XAMPP/WAMP
1. Start Apache and MySQL services
2. Copy the OOP folder to htdocs (XAMPP) or www (WAMP)
3. Access: http://localhost/OOP

## Usage Guide

### Adding a New Book
1. Click "Add New Book" button
2. Fill in the form with book details
3. Select book type from dropdown
4. Click "Add Book" to save

### Viewing Books
1. Main page shows all books in a table
2. Click "View" to see detailed information
3. Use search box to find specific books

### Editing Books
1. Click "Edit" button next to a book
2. Modify the information in the form
3. Click "Update Book" to save changes

### Deleting Books
1. Click "Delete" button next to a book
2. Confirm the deletion in the popup
3. Book will be permanently removed

### Searching Books
1. Use the search box at the top of the page
2. Enter title or author name
3. Results will be displayed in a card layout

## Security Features

1. **SQL Injection Prevention**: All database queries use prepared statements
2. **Input Validation**: Server-side validation for all user inputs
3. **XSS Prevention**: All output is properly escaped using htmlspecialchars()
4. **CSRF Protection**: Can be enhanced with CSRF tokens
5. **Error Handling**: Proper error messages without exposing system details

## Code Quality Features

1. **PSR-4 Autoloading**: Standard PHP autoloading
2. **Namespaces**: Proper code organization
3. **Type Hinting**: Method parameters and return types
4. **Documentation**: Comprehensive PHPDoc comments
5. **Error Handling**: Try-catch blocks throughout
6. **Validation**: Input validation at multiple levels

## Extension Ideas

1. **User Authentication**: Add login/logout functionality
2. **File Uploads**: Add book cover image uploads
3. **Categories**: Expand book types with custom categories
4. **API Endpoints**: Create REST API endpoints
5. **Unit Tests**: Add PHPUnit tests
6. **Pagination**: Add pagination for large datasets
7. **Sorting**: Add column sorting functionality
8. **Export**: Add CSV/PDF export features

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check MySQL is running
   - Verify database credentials in config/Database.php
   - Ensure database 'crud' exists

2. **Class Not Found Error**
   - Check autoload.php is being included
   - Verify namespace declarations
   - Check file naming conventions

3. **Permission Errors**
   - Ensure web server has read permissions
   - Check file permissions on uploaded files

4. **Blank Page**
   - Enable PHP error reporting
   - Check PHP error logs
   - Verify PHP version compatibility

### Enable PHP Error Reporting
Add this to the top of index.php for debugging:
```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

## Learning Outcomes

By studying this OOP implementation, you will learn:

1. **Object-Oriented Design Principles**
2. **Design Patterns** (Singleton, Repository, MVC)
3. **Database Interaction** with OOP approach
4. **Error Handling** best practices
5. **Security** considerations in web applications
6. **Code Organization** and structure
7. **Modern PHP** development practices

This implementation serves as an excellent foundation for understanding how to build scalable, maintainable web applications using Object-Oriented Programming principles in PHP.
