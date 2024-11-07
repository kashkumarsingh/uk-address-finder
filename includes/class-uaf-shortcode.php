<?php

namespace UKAddressFinder;

class UAF_Shortcode {

    // Register the shortcode to display the address form
    public function __construct() {
        add_shortcode('uk_address_finder_form', [$this, 'render_address_form']);
    }

    // Render the form template when the shortcode is used
    public function render_address_form() {
        ob_start(); // Start output buffering
        include plugin_dir_path(__FILE__) . '../templates/form-template.php'; // Include the form template
        return ob_get_clean(); // Return the buffered content
    }
}

// Initialize the shortcode class
new UAF_Shortcode();
