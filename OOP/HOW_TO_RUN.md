# 🚀 How to Run the PHP CRUD OOP Application

## 📋 Prerequisites Checklist

Before running the application, ensure you have:

- ✅ **PHP 7.4+** installed
- ✅ **MySQL 5.7+** or **MariaDB** installed
- ✅ Web server (Apache, Nginx) or use PHP's built-in server
- ✅ Basic understanding of OOP concepts

## 🛠️ Installation Steps

### Step 1: Database Setup

1. **Start your MySQL server** (XAMPP, WAMP, or standalone MySQL)

2. **Create the database** using one of these methods:

   **Method A: Using MySQL Command Line**
   ```sql
   mysql -u root -p
   CREATE DATABASE crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   USE crud;
   SOURCE database_setup.sql;
   ```

   **Method B: Using phpMyAdmin**
   - Open phpMyAdmin in your browser
   - Create new database named 'crud'
   - Import the `database_setup.sql` file

   **Method C: Using MySQL Workbench**
   - Connect to your MySQL server
   - Create new schema 'crud'
   - Execute the SQL script from `database_setup.sql`

### Step 2: Configure Database Connection

Edit `config/Database.php` if your MySQL credentials are different:

```php
private $host = "localhost";        // Your MySQL host
private $username = "root";         // Your MySQL username  
private $password = "";             // Your MySQL password
private $database = "crud";         // Database name
```

### Step 3: Start the Application

Choose one of these methods:

## 🎯 Method 1: PHP Built-in Server (Recommended for Development)

1. **Open PowerShell/Command Prompt**
2. **Navigate to the OOP directory:**
   ```powershell
   cd "C:\Users\DELL\Documents\Projects\php-crud-sample\OOP"
   ```
3. **Start the PHP server:**
   ```powershell
   php -S localhost:8000
   ```
4. **Open your browser and visit:**
   ```
   http://localhost:8000
   ```

## 🌐 Method 2: Using XAMPP

1. **Start XAMPP Control Panel**
2. **Start Apache and MySQL services**
3. **Copy the OOP folder to XAMPP's htdocs directory:**
   ```
   C:\xampp\htdocs\OOP\
   ```
4. **Open your browser and visit:**
   ```
   http://localhost/OOP
   ```

## 🖥️ Method 3: Using WAMP

1. **Start WAMP services**
2. **Copy the OOP folder to WAMP's www directory:**
   ```
   C:\wamp64\www\OOP\
   ```
3. **Open your browser and visit:**
   ```
   http://localhost/OOP
   ```

## 🧪 Testing the Application

1. **Run the test script first:**
   ```
   http://localhost:8000/test.php
   ```
   This will verify all OOP concepts are working correctly.

2. **Explore the main application:**
   ```
   http://localhost:8000/index.php
   ```

## 📱 Using the Application

### 📚 Viewing Books
- The main page shows all books in a responsive table
- Click "View" to see detailed information about any book
- Books are sorted by creation date (newest first)

### ➕ Adding Books
1. Click "Add New Book" button
2. Fill in all required fields:
   - **Title** (required, max 255 characters)
   - **Author** (required, max 255 characters)
   - **Type** (select from: Adventure, Crime, Fantasy, Horror)
   - **Description** (optional)
3. Click "Add Book" to save

### ✏️ Editing Books
1. Click "Edit" button next to any book
2. Modify the information in the form
3. Click "Update Book" to save changes

### 🗑️ Deleting Books
1. Click "Delete" button next to any book
2. Confirm the deletion in the JavaScript popup
3. Book will be permanently removed

### 🔍 Searching Books
1. Use the search box at the top of any page
2. Enter title or author name (partial matches work)
3. Results are displayed in a card layout
4. Search is case-insensitive

## 🎨 Features Showcase

### ✨ OOP Concepts Demonstrated

1. **Encapsulation** - Private properties with controlled access
2. **Abstraction** - Complex operations hidden behind simple methods
3. **Singleton Pattern** - Database connection management
4. **Repository Pattern** - Data access layer separation
5. **MVC Pattern** - Clear separation of concerns
6. **Dependency Injection** - Loose coupling between classes
7. **Autoloading** - PSR-4 compliant class loading
8. **Namespaces** - Logical code organization

### 🔒 Security Features

- **SQL Injection Prevention** - Prepared statements
- **XSS Protection** - Output escaping
- **Input Validation** - Server-side validation
- **Error Handling** - Graceful error management

### 🎯 Modern PHP Practices

- **Type Hinting** - Parameter and return types
- **Exception Handling** - Try-catch blocks
- **Documentation** - PHPDoc comments
- **Code Organization** - Logical file structure

## 🚨 Troubleshooting

### Common Issues and Solutions

1. **"Database connection failed"**
   ```
   Solution: 
   - Check if MySQL is running
   - Verify credentials in config/Database.php
   - Ensure database 'crud' exists
   ```

2. **"Class not found" errors**
   ```
   Solution:
   - Ensure autoload.php is included
   - Check namespace declarations
   - Verify file naming conventions
   ```

3. **Blank white page**
   ```
   Solution:
   - Enable PHP error reporting (add to index.php):
     ini_set('display_errors', 1);
     error_reporting(E_ALL);
   - Check PHP error logs
   ```

4. **Permission denied errors**
   ```
   Solution:
   - Ensure web server has read permissions
   - Check folder permissions (755 for directories, 644 for files)
   ```

### 🔧 Quick Setup Script

Run the automated setup script:
```powershell
cd "C:\Users\DELL\Documents\Projects\php-crud-sample\OOP"
.\setup.bat
```

## 📚 Learning Path

### Beginner Level
1. Study the `models/Book.php` - Learn about encapsulation
2. Examine `config/Database.php` - Understand Singleton pattern
3. Review `views/BookView.php` - See separation of concerns

### Intermediate Level
1. Analyze `repositories/BookRepository.php` - Repository pattern
2. Study `controllers/BookController.php` - MVC implementation
3. Understand the autoloading system

### Advanced Level
1. Extend the application with new features
2. Add unit tests
3. Implement additional design patterns
4. Add API endpoints

## 🔗 Quick Access URLs

When running on `localhost:8000`:

- 🏠 **Home Page:** http://localhost:8000
- ➕ **Add Book:** http://localhost:8000/create.php
- 🧪 **Test Page:** http://localhost:8000/test.php
- 🔍 **Search:** http://localhost:8000/search.php?search=fantasy

## 🎉 Success Indicators

Your application is working correctly when you can:

- ✅ See the book list on the main page
- ✅ Add new books successfully
- ✅ Edit existing books
- ✅ Delete books with confirmation
- ✅ Search books by title/author
- ✅ See flash messages for operations
- ✅ Navigate between pages smoothly

## 📞 Need Help?

If you encounter any issues:
1. Check the troubleshooting section above
2. Review the error messages carefully
3. Examine the PHP error logs
4. Test individual components using test.php

---

**Happy Coding! 🚀**

This OOP implementation demonstrates modern PHP development practices and serves as an excellent foundation for building larger applications.
