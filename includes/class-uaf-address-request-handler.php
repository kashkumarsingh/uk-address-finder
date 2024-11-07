<?php

namespace UKAddressFinder;

use UKAddressFinder\Interfaces\AddressFetcherInterface;
use UKAddressFinder\Interfaces\SuggestionFactoryInterface;

class UAF_Address_Request_Handler
{
    private $address_fetcher;
    private $suggestion_factory;

    public function __construct(AddressFetcherInterface $address_fetcher, SuggestionFactoryInterface $suggestion_factory)
    {
        $this->address_fetcher = $address_fetcher;
        $this->suggestion_factory = $suggestion_factory;
    }

    // Handle AJAX request for address suggestions
    public function handle_request()
    {
        // Verify nonce for security
        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'uk_address_finder_nonce_action')) {
            wp_send_json_error('Nonce verification failed.');
            return;
        }

        // Postal code validation
        if (empty($_POST['postal_code'])) {
            wp_send_json_error('Postal code is required.');
            return;
        }

        $postal_code = sanitize_text_field($_POST['postal_code']); // Assign value to $postal_code here

        // Validate the postal code format
        if (!$this->is_valid_postal_code($postal_code)) {
            wp_send_json_error('Invalid postal code format.');
            return;
        }

        // Fetch addresses using the address fetcher
        $address_data = $this->address_fetcher->fetch_addresses($postal_code);
        error_log(print_r($address_data, true));  // Log the fetched address data

        // Create address suggestions
        $suggestions = $this->suggestion_factory->create_suggestions($address_data);
        if (empty($suggestions)) {
            error_log('No address suggestions found.');
        }

        // Send response
        if (!empty($suggestions)) {
            wp_send_json_success($suggestions);
        } else {
            wp_send_json_error('No addresses found or invalid API key.');
        }
    }

    // Postal code validation method
    private function is_valid_postal_code($postal_code)
    {
        return preg_match('/^[A-Z]{1,2}\d{1,2} ?\d[A-Z]{2}$/i', strtoupper($postal_code));
    }
    
}


