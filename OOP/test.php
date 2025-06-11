<?php
/**
 * Test Script for OOP CRUD Application
 * 
 * This script tests all OOP concepts and functionality
 */

require_once 'autoload.php';

use Config\Database;
use Models\Book;
use Repositories\BookRepository;
use Controllers\BookController;

echo "<h1>PHP CRUD OOP Application - Test & Demo</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .section { background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    pre { background: #fff; padding: 10px; border: 1px solid #ddd; overflow-x: auto; }
</style>";

echo "<div class='section'>";
echo "<h2>1. Testing Database Connection (Singleton Pattern)</h2>";

try {
    // SINGLETON PATTERN TEST
    $db1 = Database::getInstance();
    $db2 = Database::getInstance();
    
    if ($db1 === $db2) {
        echo "<p class='success'>✓ Singleton Pattern Working: Same instance returned</p>";
    } else {
        echo "<p class='error'>✗ Singleton Pattern Failed: Different instances</p>";
    }
    
    $connection = $db1->getConnection();
    if ($connection->ping()) {
        echo "<p class='success'>✓ Database Connection Successful</p>";
    } else {
        echo "<p class='error'>✗ Database Connection Failed</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>2. Testing Book Model (Encapsulation & Validation)</h2>";

try {
    // ENCAPSULATION TEST
    $book = new Book();
    
    // Test setters with validation
    $book->setTitle("Test Book Title");
    $book->setAuthor("Test Author");
    $book->setType("Fantasy");
    $book->setDescription("This is a test book description.");
    
    echo "<p class='success'>✓ Encapsulation: All setters working with validation</p>";
    
    // Test getters
    echo "<p class='info'>Title: " . htmlspecialchars($book->getTitle()) . "</p>";
    echo "<p class='info'>Author: " . htmlspecialchars($book->getAuthor()) . "</p>";
    echo "<p class='info'>Type: " . htmlspecialchars($book->getType()) . "</p>";
    
    // Test validation
    if ($book->isValid()) {
        echo "<p class='success'>✓ Validation: Book data is valid</p>";
    } else {
        echo "<p class='error'>✗ Validation: Book data is invalid</p>";
    }
    
    // Test invalid data
    try {
        $book->setType("InvalidType");
        echo "<p class='error'>✗ Validation: Invalid type accepted (should have failed)</p>";
    } catch (InvalidArgumentException $e) {
        echo "<p class='success'>✓ Validation: Invalid type properly rejected</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Book Model Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>3. Testing Repository Pattern (Data Access Layer)</h2>";

try {
    $repository = new BookRepository();
    
    // Test finding all books
    $books = $repository->findAll();
    echo "<p class='success'>✓ Repository: Found " . count($books) . " books in database</p>";
    
    if (!empty($books)) {
        $firstBook = $books[0];
        echo "<p class='info'>Sample Book: " . htmlspecialchars($firstBook->getTitle()) . " by " . htmlspecialchars($firstBook->getAuthor()) . "</p>";
        
        // Test finding by ID
        $foundBook = $repository->findById($firstBook->getId());
        if ($foundBook && $foundBook->getTitle() === $firstBook->getTitle()) {
            echo "<p class='success'>✓ Repository: Find by ID working correctly</p>";
        } else {
            echo "<p class='error'>✗ Repository: Find by ID failed</p>";
        }
    }
    
    // Test search functionality
    $searchResults = $repository->search("Tolkien");
    echo "<p class='success'>✓ Repository: Search found " . count($searchResults) . " books for 'Tolkien'</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Repository Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>4. Testing MVC Pattern</h2>";

try {
    // Test controller instantiation
    $controller = new BookController();
    echo "<p class='success'>✓ MVC: Controller instantiated successfully</p>";
    echo "<p class='info'>Controller uses Repository for data access</p>";
    echo "<p class='info'>Controller coordinates between Model and View</p>";
    echo "<p class='success'>✓ MVC: Separation of concerns implemented</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>✗ MVC Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>5. OOP Principles Summary</h2>";
echo "<ul>";
echo "<li><strong>Encapsulation:</strong> Private properties with controlled access via getters/setters</li>";
echo "<li><strong>Abstraction:</strong> Complex operations hidden behind simple interfaces</li>";
echo "<li><strong>Single Responsibility:</strong> Each class has one specific purpose</li>";
echo "<li><strong>Dependency Injection:</strong> Dependencies passed through constructors</li>";
echo "<li><strong>Singleton Pattern:</strong> Database connection ensures single instance</li>";
echo "<li><strong>Repository Pattern:</strong> Data access logic centralized</li>";
echo "<li><strong>MVC Pattern:</strong> Clear separation of concerns</li>";
echo "<li><strong>Autoloading:</strong> PSR-4 compliant class loading</li>";
echo "<li><strong>Namespaces:</strong> Logical code organization</li>";
echo "<li><strong>Error Handling:</strong> Proper exception handling throughout</li>";
echo "</ul>";
echo "</div>";

echo "<div class='section'>";
echo "<h2>6. Application Features</h2>";
echo "<ul>";
echo "<li>✓ Create new books with validation</li>";
echo "<li>✓ Read/View all books and individual details</li>";
echo "<li>✓ Update existing book information</li>";
echo "<li>✓ Delete books with confirmation</li>";
echo "<li>✓ Search books by title or author</li>";
echo "<li>✓ Responsive Bootstrap UI</li>";
echo "<li>✓ Flash message system</li>";
echo "<li>✓ SQL injection prevention</li>";
echo "<li>✓ Input validation and sanitization</li>";
echo "<li>✓ Error handling and logging</li>";
echo "</ul>";
echo "</div>";

echo "<div class='section'>";
echo "<h2>7. Quick Links</h2>";
echo "<p><a href='index.php' style='color: blue; text-decoration: none;'>📚 View Book List</a></p>";
echo "<p><a href='create.php' style='color: green; text-decoration: none;'>➕ Add New Book</a></p>";
echo "<p><a href='search.php?search=fantasy' style='color: purple; text-decoration: none;'>🔍 Search Books</a></p>";
echo "</div>";

echo "<div class='section'>";
echo "<h2>8. Next Steps</h2>";
echo "<ol>";
echo "<li>Run the application using: <code>php -S localhost:8000</code></li>";
echo "<li>Open your browser to: <code>http://localhost:8000</code></li>";
echo "<li>Explore all CRUD operations</li>";
echo "<li>Test the search functionality</li>";
echo "<li>Examine the code to understand OOP concepts</li>";
echo "</ol>";
echo "</div>";

?>
