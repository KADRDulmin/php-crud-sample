<?php
/**
 * Book Controller Class
 * 
 * OOP Concepts Used:
 * 1. MVC PATTERN: Controller handles user input and coordinates between Model and View
 * 2. DEPENDENCY INJECTION: Repository dependency is injected
 * 3. SEPARATION OF CONCERNS: Controller only handles HTTP requests/responses
 * 4. ERROR HANDLING: Centralized error handling for all operations
 * 5. SINGLE RESPONSIBILITY: Each method handles one specific action
 */

namespace Controllers;

use Repositories\BookRepository;
use Models\Book;
use Views\BookView;

class BookController {
    // ENCAPSULATION: Private dependencies
    private $bookRepository;
    private $bookView;
    
    /**
     * DEPENDENCY INJECTION: Constructor receives dependencies
     */
    public function __construct() {
        $this->bookRepository = new BookRepository();
        $this->bookView = new BookView();
    }
    
    /**
     * INDEX ACTION: Display all books
     * MVC PATTERN: Controller gets data from Model and passes to View
     */
    public function index() {
        try {
            session_start();
            $books = $this->bookRepository->findAll();
            $this->bookView->displayBookList($books, $this->getFlashMessages());
        } catch (\Exception $e) {
            $this->handleError("Error loading books: " . $e->getMessage());
        }
    }
    
    /**
     * SHOW ACTION: Display single book details
     * @param int $id Book ID
     */
    public function show($id) {
        try {
            $book = $this->bookRepository->findById($id);
            
            if (!$book) {
                $this->handleError("Book not found", 404);
                return;
            }
            
            $this->bookView->displayBookDetails($book);
        } catch (\Exception $e) {
            $this->handleError("Error loading book: " . $e->getMessage());
        }
    }
    
    /**
     * CREATE FORM ACTION: Display form for creating new book
     */
    public function createForm() {
        $this->bookView->displayCreateForm();
    }
    
    /**
     * CREATE ACTION: Process new book creation
     */
    public function create() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->redirect('index.php');
                return;
            }
            
            // DATA VALIDATION and OBJECT CREATION
            $book = new Book();
            $book->setTitle($_POST['title'] ?? '');
            $book->setAuthor($_POST['author'] ?? '');
            $book->setType($_POST['type'] ?? '');
            $book->setDescription($_POST['description'] ?? '');
            
            // BUSINESS LOGIC: Save through repository
            if ($this->bookRepository->create($book)) {
                $this->setFlashMessage('create', 'Book added successfully!');
                $this->redirect('index.php');
            } else {
                throw new \Exception("Failed to create book");
            }
            
        } catch (\InvalidArgumentException $e) {
            $this->handleError("Validation Error: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->handleError("Error creating book: " . $e->getMessage());
        }
    }
    
    /**
     * EDIT FORM ACTION: Display form for editing book
     * @param int $id Book ID
     */
    public function editForm($id) {
        try {
            $book = $this->bookRepository->findById($id);
            
            if (!$book) {
                $this->handleError("Book not found", 404);
                return;
            }
            
            $this->bookView->displayEditForm($book);
        } catch (\Exception $e) {
            $this->handleError("Error loading book for edit: " . $e->getMessage());
        }
    }
    
    /**
     * UPDATE ACTION: Process book update
     */
    public function update() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->redirect('index.php');
                return;
            }
            
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new \InvalidArgumentException("Book ID is required");
            }
            
            // OBJECT RETRIEVAL and MODIFICATION
            $book = $this->bookRepository->findById($id);
            if (!$book) {
                throw new \Exception("Book not found");
            }
            
            // UPDATE OBJECT PROPERTIES
            $book->setTitle($_POST['title'] ?? '');
            $book->setAuthor($_POST['author'] ?? '');
            $book->setType($_POST['type'] ?? '');
            $book->setDescription($_POST['description'] ?? '');
            
            // BUSINESS LOGIC: Update through repository
            if ($this->bookRepository->update($book)) {
                $this->setFlashMessage('update', 'Book updated successfully!');
                $this->redirect('index.php');
            } else {
                throw new \Exception("Failed to update book");
            }
            
        } catch (\InvalidArgumentException $e) {
            $this->handleError("Validation Error: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->handleError("Error updating book: " . $e->getMessage());
        }
    }
    
    /**
     * DELETE ACTION: Delete book
     * @param int $id Book ID
     */
    public function delete($id) {
        try {
            if (!$this->bookRepository->exists($id)) {
                $this->handleError("Book not found", 404);
                return;
            }
            
            if ($this->bookRepository->delete($id)) {
                $this->setFlashMessage('delete', 'Book deleted successfully!');
            } else {
                throw new \Exception("Failed to delete book");
            }
            
            $this->redirect('index.php');
            
        } catch (\Exception $e) {
            $this->handleError("Error deleting book: " . $e->getMessage());
        }
    }
    
    /**
     * SEARCH ACTION: Search books
     */
    public function search() {
        try {
            $searchTerm = $_GET['search'] ?? '';
            
            if (empty(trim($searchTerm))) {
                $this->redirect('index.php');
                return;
            }
            
            $books = $this->bookRepository->search($searchTerm);
            $this->bookView->displaySearchResults($books, $searchTerm);
            
        } catch (\Exception $e) {
            $this->handleError("Error searching books: " . $e->getMessage());
        }
    }
    
    /**
     * ERROR HANDLING: Centralized error handling
     * @param string $message Error message
     * @param int $code HTTP status code
     */
    private function handleError($message, $code = 500) {
        http_response_code($code);
        $this->bookView->displayError($message);
    }
    
    /**
     * FLASH MESSAGES: Set success/error messages
     * @param string $type Message type
     * @param string $message Message content
     */
    private function setFlashMessage($type, $message) {
        session_start();
        $_SESSION[$type] = $message;
    }
    
    /**
     * FLASH MESSAGES: Get and clear flash messages
     * @return array Flash messages
     */
    private function getFlashMessages() {
        $messages = [];
        
        if (isset($_SESSION['create'])) {
            $messages['create'] = $_SESSION['create'];
            unset($_SESSION['create']);
        }
        
        if (isset($_SESSION['update'])) {
            $messages['update'] = $_SESSION['update'];
            unset($_SESSION['update']);
        }
        
        if (isset($_SESSION['delete'])) {
            $messages['delete'] = $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        
        return $messages;
    }
    
    /**
     * REDIRECTION: Redirect to another page
     * @param string $location Target location
     */
    private function redirect($location) {
        header("Location: $location");
        exit;
    }
}
?>
