<?php
/**
 * Create New Book Page
 * 
 * OOP Concepts Used:
 * 1. SINGLE RESPONSIBILITY: This file only handles the create book action
 * 2. CONTROLLER DELEGATION: Delegates all logic to the controller
 */

require_once 'autoload.php';

use Controllers\BookController;

try {
    $controller = new BookController();
    
    // Handle both GET (show form) and POST (process form) requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // POLYMORPHISM: Same controller handles different actions
        $controller->create();
    } else {
        $controller->createForm();
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
