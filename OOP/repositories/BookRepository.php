<?php
/**
 * Book Repository Class
 * 
 * OOP Concepts Used:
 * 1. REPOSITORY PATTERN: Encapsulates data access logic
 * 2. DEPENDENCY INJECTION: Database dependency is injected through constructor
 * 3. SINGLE RESPONSIBILITY: This class only handles Book data operations
 * 4. ABSTRACTION: Complex SQL operations are abstracted into simple methods
 * 5. ERROR HANDLING: Proper exception handling for database operations
 */

namespace Repositories;

use Config\Database;
use Models\Book;

class BookRepository {
    // ENCAPSULATION: Private database connection
    private $db;
    private $connection;
    
    /**
     * DEPENDENCY INJECTION: Constructor receives database dependency
     */
    public function __construct() {
        $this->db = Database::getInstance();
        $this->connection = $this->db->getConnection();
    }
    
    /**
     * CREATE OPERATION: Add new book to database
     * @param Book $book Book object to save
     * @return bool Success status
     * @throws Exception Database errors
     */
    public function create(Book $book) {
        try {
            // VALIDATION: Ensure book data is valid before saving
            if (!$book->isValid()) {
                throw new \InvalidArgumentException("Invalid book data");
            }
            
            $sql = "INSERT INTO books (title, author, type, description) VALUES (?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new \Exception("Prepare failed: " . $this->connection->error);
            }
            
            // SECURITY: Using prepared statements to prevent SQL injection
            $stmt->bind_param("ssss", 
                $book->getTitle(),
                $book->getAuthor(), 
                $book->getType(),
                $book->getDescription()
            );
            
            $result = $stmt->execute();
            
            if ($result) {
                // Set the generated ID back to the book object
                $book->setId($this->connection->insert_id);
            }
            
            $stmt->close();
            return $result;
            
        } catch (\Exception $e) {
            throw new \Exception("Error creating book: " . $e->getMessage());
        }
    }
    
    /**
     * READ OPERATION: Get book by ID
     * @param int $id Book ID
     * @return Book|null Book object or null if not found
     */
    public function findById($id) {
        try {
            $sql = "SELECT * FROM books WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new \Exception("Prepare failed: " . $this->connection->error);
            }
            
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $stmt->close();
                return new Book($row); // OBJECT CREATION from database data
            }
            
            $stmt->close();
            return null;
            
        } catch (\Exception $e) {
            throw new \Exception("Error finding book: " . $e->getMessage());
        }
    }
    
    /**
     * READ OPERATION: Get all books
     * @return array Array of Book objects
     */
    public function findAll() {
        try {
            $sql = "SELECT * FROM books ORDER BY created_at DESC";
            $result = $this->connection->query($sql);
            
            if (!$result) {
                throw new \Exception("Query failed: " . $this->connection->error);
            }
            
            $books = [];
            while ($row = $result->fetch_assoc()) {
                $books[] = new Book($row); // OBJECT CREATION for each row
            }
            
            return $books;
            
        } catch (\Exception $e) {
            throw new \Exception("Error fetching books: " . $e->getMessage());
        }
    }
    
    /**
     * UPDATE OPERATION: Update existing book
     * @param Book $book Book object with updated data
     * @return bool Success status
     */
    public function update(Book $book) {
        try {
            // VALIDATION: Ensure book has ID and valid data
            if (!$book->getId()) {
                throw new \InvalidArgumentException("Book ID is required for update");
            }
            
            if (!$book->isValid()) {
                throw new \InvalidArgumentException("Invalid book data");
            }
            
            $sql = "UPDATE books SET title = ?, author = ?, type = ?, description = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new \Exception("Prepare failed: " . $this->connection->error);
            }
            
            $stmt->bind_param("ssssi",
                $book->getTitle(),
                $book->getAuthor(),
                $book->getType(),
                $book->getDescription(),
                $book->getId()
            );
            
            $result = $stmt->execute();
            $stmt->close();
            
            return $result;
            
        } catch (\Exception $e) {
            throw new \Exception("Error updating book: " . $e->getMessage());
        }
    }
    
    /**
     * DELETE OPERATION: Delete book by ID
     * @param int $id Book ID
     * @return bool Success status
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM books WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new \Exception("Prepare failed: " . $this->connection->error);
            }
            
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            
            return $result;
            
        } catch (\Exception $e) {
            throw new \Exception("Error deleting book: " . $e->getMessage());
        }
    }
    
    /**
     * SEARCH OPERATION: Search books by title or author
     * @param string $searchTerm Search term
     * @return array Array of matching Book objects
     */
    public function search($searchTerm) {
        try {
            $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY created_at DESC";
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new \Exception("Prepare failed: " . $this->connection->error);
            }
            
            $searchPattern = "%{$searchTerm}%";
            $stmt->bind_param("ss", $searchPattern, $searchPattern);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $books = [];
            while ($row = $result->fetch_assoc()) {
                $books[] = new Book($row);
            }
            
            $stmt->close();
            return $books;
            
        } catch (\Exception $e) {
            throw new \Exception("Error searching books: " . $e->getMessage());
        }
    }
    
    /**
     * UTILITY: Check if book exists
     * @param int $id Book ID
     * @return bool True if exists, false otherwise
     */
    public function exists($id) {
        return $this->findById($id) !== null;
    }
}
?>
