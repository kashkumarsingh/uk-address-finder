<?php

namespace UKAddressFinder;

class UAF_Assets_Handler
{
    // Enqueue the necessary scripts and styles
    public static function enqueue_assets()
    {
        // Enqueue JS script with versioning for cache busting
        wp_enqueue_script(
            'uk-address-finder', 
            plugins_url('../assets/dist/js/uk-address-finder.min.js', __FILE__), 
            ['jquery'], // Add jQuery dependency if needed
            filemtime(plugin_dir_path(__FILE__) . '../assets/dist/js/uk-address-finder.min.js'), // Cache busting based on file modification time
            true
        );

        // Localize script for AJAX URL
        wp_localize_script('uk-address-finder', 'UKAddressFinder', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('uk_address_finder_nonce_action') // Add nonce for security
        ]);

        // Enqueue CSS if needed
        wp_enqueue_style(
            'uk-address-finder-style',
            plugins_url('../assets/dist/css/uk-address-finder.min.css', __FILE__),
            [], 
            filemtime(plugin_dir_path(__FILE__) . '../assets/dist/css/uk-address-finder.min.css') // Cache busting for CSS
        );
    }
}
