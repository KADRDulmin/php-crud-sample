<?php
/**
 * Edit Book Page
 * 
 * OOP Concepts Used:
 * 1. INPUT VALIDATION: Validates user input before processing
 * 2. ERROR HANDLING: Proper error handling for invalid requests
 */

require_once 'autoload.php';

use Controllers\BookController;

try {
    $controller = new BookController();
    
    // INPUT VALIDATION: Ensure ID is provided
    $id = $_GET['id'] ?? null;
    
    if (!$id || !is_numeric($id)) {
        throw new InvalidArgumentException("Valid book ID is required");
    }
    
    // DELEGATION: Let controller handle the edit form display
    $controller->editForm((int)$id);
    
} catch (Exception $e) {
    http_response_code(400);
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<a href='index.php' class='btn btn-primary'>Back to List</a>";
}
?>
