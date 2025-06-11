<?php
/**
 * Search Books Page
 * 
 * OOP Concepts Used:
 * 1. SEARCH FUNCTIONALITY: Implements search feature using OOP principles
 * 2. INPUT SANITIZATION: Safely handles user search input
 */

require_once 'autoload.php';

use Controllers\BookController;

try {
    $controller = new BookController();
    
    // DELEGATION: Let controller handle the search logic
    $controller->search();
    
} catch (Exception $e) {
    http_response_code(500);
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<a href='index.php' class='btn btn-primary'>Back to List</a>";
}
?>
