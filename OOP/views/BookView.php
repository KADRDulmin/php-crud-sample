<?php
/**
 * Book View Class
 * 
 * OOP Concepts Used:
 * 1. MVC PATTERN: View layer responsible for presentation logic
 * 2. SEPARATION OF CONCERNS: Only handles HTML output and user interface
 * 3. TEMPLATE METHOD PATTERN: Common HTML structure in base methods
 * 4. ENCAPSULATION: Private methods for reusable HTML components
 * 5. SINGLE RESPONSIBILITY: Each method renders specific view
 */

namespace Views;

use Models\Book;

class BookView {
    
    /**
     * TEMPLATE METHOD: Display book list page
     * @param array $books Array of Book objects
     * @param array $messages Flash messages
     */
    public function displayBookList($books, $messages = []) {
        $this->renderHeader("Book List");
        ?>
        <div class="container my-4">
            <header class="d-flex justify-content-between my-4">
                <h1>Book Management System (OOP Version)</h1>
                <div>
                    <a href="create.php" class="btn btn-primary">Add New Book</a>
                </div>
            </header>
            
            <?php $this->renderFlashMessages($messages); ?>
            <?php $this->renderSearchForm(); ?>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Type</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($books)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No books found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($books as $book): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($book->getId()); ?></td>
                                    <td><?php echo htmlspecialchars($book->getTitle()); ?></td>
                                    <td><?php echo htmlspecialchars($book->getAuthor()); ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?php echo htmlspecialchars($book->getType()); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($book->getCreatedAt())); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="view.php?id=<?php echo $book->getId(); ?>" 
                                               class="btn btn-info btn-sm">View</a>
                                            <a href="edit.php?id=<?php echo $book->getId(); ?>" 
                                               class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete.php?id=<?php echo $book->getId(); ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        $this->renderFooter();
    }
    
    /**
     * Display single book details
     * @param Book $book Book object to display
     */
    public function displayBookDetails($book) {
        $this->renderHeader("Book Details");
        ?>
        <div class="container my-4">
            <header class="d-flex justify-content-between my-4">
                <h1>Book Details</h1>
                <div>
                    <a href="index.php" class="btn btn-primary">Back to List</a>
                    <a href="edit.php?id=<?php echo $book->getId(); ?>" class="btn btn-warning">Edit</a>
                </div>
            </header>
            
            <div class="card">
                <div class="card-header">
                    <h3><?php echo htmlspecialchars($book->getTitle()); ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Author:</h5>
                            <p><?php echo htmlspecialchars($book->getAuthor()); ?></p>
                            
                            <h5>Type:</h5>
                            <p><span class="badge bg-secondary"><?php echo htmlspecialchars($book->getType()); ?></span></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Created:</h5>
                            <p><?php echo date('F j, Y g:i A', strtotime($book->getCreatedAt())); ?></p>
                            
                            <?php if ($book->getUpdatedAt() !== $book->getCreatedAt()): ?>
                            <h5>Last Updated:</h5>
                            <p><?php echo date('F j, Y g:i A', strtotime($book->getUpdatedAt())); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <h5>Description:</h5>
                    <div class="bg-light p-3 rounded">
                        <?php echo nl2br(htmlspecialchars($book->getDescription())); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->renderFooter();
    }
    
    /**
     * Display create form
     */
    public function displayCreateForm() {
        $this->renderHeader("Add New Book");
        ?>
        <div class="container my-5">
            <header class="d-flex justify-content-between my-4">
                <h1>Add New Book</h1>
                <div>
                    <a href="index.php" class="btn btn-primary">Back to List</a>
                </div>
            </header>
            
            <?php $this->renderBookForm(); ?>
        </div>
        <?php
        $this->renderFooter();
    }
    
    /**
     * Display edit form
     * @param Book $book Book object to edit
     */
    public function displayEditForm($book) {
        $this->renderHeader("Edit Book");
        ?>
        <div class="container my-5">
            <header class="d-flex justify-content-between my-4">
                <h1>Edit Book</h1>
                <div>
                    <a href="index.php" class="btn btn-primary">Back to List</a>
                </div>
            </header>
            
            <?php $this->renderBookForm($book); ?>
        </div>
        <?php
        $this->renderFooter();
    }
    
    /**
     * Display search results
     * @param array $books Array of Book objects
     * @param string $searchTerm Search term used
     */
    public function displaySearchResults($books, $searchTerm) {
        $this->renderHeader("Search Results");
        ?>
        <div class="container my-4">
            <header class="d-flex justify-content-between my-4">
                <h1>Search Results for "<?php echo htmlspecialchars($searchTerm); ?>"</h1>
                <div>
                    <a href="index.php" class="btn btn-primary">Back to List</a>
                </div>
            </header>
            
            <?php $this->renderSearchForm($searchTerm); ?>
            
            <p class="text-muted"><?php echo count($books); ?> book(s) found</p>
            
            <?php if (empty($books)): ?>
                <div class="alert alert-info">
                    No books found matching your search criteria.
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($books as $book): ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($book->getTitle()); ?></h5>
                                    <p class="card-text">
                                        <strong>Author:</strong> <?php echo htmlspecialchars($book->getAuthor()); ?><br>
                                        <strong>Type:</strong> <span class="badge bg-secondary"><?php echo htmlspecialchars($book->getType()); ?></span>
                                    </p>
                                    <div class="btn-group" role="group">
                                        <a href="view.php?id=<?php echo $book->getId(); ?>" class="btn btn-info btn-sm">View</a>
                                        <a href="edit.php?id=<?php echo $book->getId(); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        $this->renderFooter();
    }
    
    /**
     * Display error page
     * @param string $message Error message
     */
    public function displayError($message) {
        $this->renderHeader("Error");
        ?>
        <div class="container my-4">
            <div class="alert alert-danger">
                <h4>Error</h4>
                <p><?php echo htmlspecialchars($message); ?></p>
                <a href="index.php" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
        <?php
        $this->renderFooter();
    }
    
    /**
     * ENCAPSULATION: Private method to render HTML header
     * @param string $title Page title
     */
    private function renderHeader($title) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($title); ?> - Book Management</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
            <style>
                .table td, .table th {
                    vertical-align: middle;
                    padding: 15px !important;
                }
                .btn-group .btn {
                    margin-right: 5px;
                }
                .card {
                    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                }
            </style>
        </head>
        <body class="bg-light">
        <?php
    }
    
    /**
     * ENCAPSULATION: Private method to render HTML footer
     */
    private function renderFooter() {
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
    
    /**
     * ENCAPSULATION: Private method to render flash messages
     * @param array $messages Flash messages
     */
    private function renderFlashMessages($messages) {
        foreach ($messages as $type => $message) {
            $alertClass = $type === 'delete' ? 'alert-warning' : 'alert-success';
            ?>
            <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php
        }
    }
    
    /**
     * ENCAPSULATION: Private method to render book form
     * @param Book|null $book Book object for editing (null for create)
     */
    private function renderBookForm($book = null) {
        $isEdit = $book !== null;
        $action = $isEdit ? 'update.php' : 'create.php';
        ?>
        <div class="card">
            <div class="card-body">
                <form action="<?php echo $action; ?>" method="post">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?php echo $book->getId(); ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Book Title *</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo $isEdit ? htmlspecialchars($book->getTitle()) : ''; ?>" 
                               required maxlength="255">
                    </div>
                    
                    <div class="mb-3">
                        <label for="author" class="form-label">Author Name *</label>
                        <input type="text" class="form-control" id="author" name="author" 
                               value="<?php echo $isEdit ? htmlspecialchars($book->getAuthor()) : ''; ?>" 
                               required maxlength="255">
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label">Book Type *</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Select Book Type</option>
                            <?php foreach (Book::VALID_TYPES as $type): ?>
                                <option value="<?php echo $type; ?>" 
                                        <?php echo ($isEdit && $book->getType() === $type) ? 'selected' : ''; ?>>
                                    <?php echo $type; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo $isEdit ? htmlspecialchars($book->getDescription()) : ''; ?></textarea>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <?php echo $isEdit ? 'Update Book' : 'Add Book'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    
    /**
     * ENCAPSULATION: Private method to render search form
     * @param string $searchTerm Current search term
     */
    private function renderSearchForm($searchTerm = '') {
        ?>
        <div class="card mb-4">
            <div class="card-body">
                <form action="search.php" method="get" class="d-flex">
                    <input type="text" class="form-control me-2" name="search" 
                           placeholder="Search books by title or author..." 
                           value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Search
                    </button>
                </form>
            </div>
        </div>
        <?php
    }
}
?>
