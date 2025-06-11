<?php
/**
 * Autoloader for OOP Book Management System
 * 
 * OOP Concepts Used:
 * 1. AUTOLOADING: Automatically loads classes when needed
 * 2. NAMESPACE SUPPORT: Maps namespaces to directory structure
 * 3. PSR-4 STANDARD: Follows PHP autoloading standards
 */

spl_autoload_register(function ($className) {
    // Convert namespace separator to directory separator
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    
    // Convert first character of each part to lowercase for directory names
    $parts = explode(DIRECTORY_SEPARATOR, $className);
    for ($i = 0; $i < count($parts) - 1; $i++) {
        $parts[$i] = strtolower($parts[$i]);
    }
    $className = implode(DIRECTORY_SEPARATOR, $parts);
    
    // Build the file path
    $file = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
    
    // Include the file if it exists
    if (file_exists($file)) {
        require_once $file;
    }
});
?>
