<?php
/**
 * Main Index Page - Book List
 * 
 * OOP Concepts Used:
 * 1. FRONT CONTROLLER PATTERN: Single entry point for the application
 * 2. DEPENDENCY INJECTION: All dependencies are handled by the controller
 * 3. SEPARATION OF CONCERNS: This file only handles routing to the controller
 */

// AUTOLOADING: Load all required classes automatically
require_once 'autoload.php';

use Controllers\BookController;

try {
    // OBJECT INSTANTIATION: Create controller instance
    $controller = new BookController();
    
    // DELEGATION: Delegate the index action to the controller
    $controller->index();
    
} catch (Exception $e) {
    // GLOBAL ERROR HANDLING: Catch any unhandled exceptions
    http_response_code(500);
    echo "<div class='alert alert-danger'>System Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
