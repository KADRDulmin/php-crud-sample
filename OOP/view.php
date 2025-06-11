<?php
/**
 * View Book Details Page
 * 
 * OOP Concepts Used:
 * 1. PARAMETER VALIDATION: Validates URL parameters
 * 2. ERROR HANDLING: Handles missing or invalid book IDs
 */

require_once 'autoload.php';

use Controllers\BookController;

try {
    $controller = new BookController();
    
    // INPUT VALIDATION: Ensure ID is provided and valid
    $id = $_GET['id'] ?? null;
    
    if (!$id || !is_numeric($id)) {
        throw new InvalidArgumentException("Valid book ID is required");
    }
    
    // DELEGATION: Let controller handle the view logic
    $controller->show((int)$id);
    
} catch (Exception $e) {
    http_response_code(400);
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<a href='index.php' class='btn btn-primary'>Back to List</a>";
}
?>
