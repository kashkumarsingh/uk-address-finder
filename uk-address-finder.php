<?php
/**
 * Plugin Name: UK Address Finder
 * Description: Provides address suggestions based on UK postal codes.
 */

namespace UKAddressFinder;

if (!defined('ABSPATH')) {
    exit;
}

// Autoloader for dynamically loading classes
require_once plugin_dir_path(__FILE__) . 'includes/autoload.php';

// Updated class imports based on new class names
use UKAddressFinder\UAF_Main;
use UKAddressFinder\UAF_Address_Fetcher;
use UKAddressFinder\UAF_Address_Suggestion_Factory;
use UKAddressFinder\UAF_Shortcode;

add_action('plugins_loaded', function () {
    // Instantiate classes based on the updated naming convention
    $address_fetcher = new UAF_Address_Fetcher();
    $suggestion_factory = new UAF_Address_Suggestion_Factory();

    // Initialize the main plugin class (singleton)
    $uk_address_finder = UAF_Main::get_instance();

    // Manually inject the dependencies after singleton creation
    $uk_address_finder->set_dependencies($address_fetcher, $suggestion_factory);

    // Register hooks
    $uk_address_finder->register_hooks();

    // Initialize the shortcode
    new UAF_Shortcode();
});
