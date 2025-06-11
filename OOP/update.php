<?php
/**
 * Update Book Page
 * 
 * OOP Concepts Used:
 * 1. HTTP METHOD VALIDATION: Only accepts POST requests
 * 2. SECURITY: Validates request method before processing
 */

require_once 'autoload.php';

use Controllers\BookController;

try {
    // SECURITY: Only allow POST requests for updates
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php");
        exit;
    }
    
    $controller = new BookController();
    
    // DELEGATION: Let controller handle the update logic
    $controller->update();
    
} catch (Exception $e) {
    http_response_code(500);
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<a href='index.php' class='btn btn-primary'>Back to List</a>";
}
?>
