<?php

// Autoloader for dynamically loading UK Address Finder classes and interfaces
spl_autoload_register(function ($class) {
    // Define the namespace prefix for the classes
    $prefix = 'UKAddressFinder\\';
    $base_dir = __DIR__ . '/';

    // Check if the class uses the namespace prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // Not in the desired namespace, skip
    }

    // Get the relative class name by removing the namespace prefix
    $relative_class = substr($class, $len);

    // Convert namespace separators to directory separators
    $relative_path = strtolower(str_replace('\\', '/', $relative_class));

    // Determine if the class is an interface by checking for the "Interface" suffix
    $is_interface = (substr($relative_class, -9) === 'Interface');

    // Construct the file path for interfaces and classes
    if ($is_interface) {
        // Interfaces should be in the "Interfaces" subdirectory without prefixing `class-`
        $file = $base_dir  . $relative_path . '.php';
    } else {
        // For classes, prefix with "class-uaf-" and convert underscores to hyphens
        $file = $base_dir . 'class-' . str_replace('_', '-', $relative_path) . '.php';
    }

    // Ensure the file exists before including it
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Log an error if the file cannot be found
        error_log("Autoloader: Failed to load class '$class'. File '$file' does not exist.");
    }
});
