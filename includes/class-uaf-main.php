<?php

namespace UKAddressFinder;

use UKAddressFinder\Interfaces\AddressFetcherInterface;
use UKAddressFinder\Interfaces\SuggestionFactoryInterface;

class UAF_Main
{
    use UAF_Singleton;

    private $address_fetcher;
    private $address_suggestion_factory;

    // Private constructor to prevent direct instantiation
    protected function __construct() {}

    // Method to manually inject dependencies after instance creation
    public function set_dependencies(AddressFetcherInterface $address_fetcher, SuggestionFactoryInterface $address_suggestion_factory)
    {
        $this->address_fetcher = $address_fetcher;
        $this->address_suggestion_factory = $address_suggestion_factory;
    }

    // Register hooks for the plugin
    public function register_hooks()
    {
        // Register script enqueuing
        add_action('wp_enqueue_scripts', [UAF_Assets_Handler::class, 'enqueue_assets']);
    
        // Register AJAX handling for both logged-in and non-logged-in users
        add_action('wp_ajax_get_address_suggestions', [$this, 'handle_ajax_request']);
        add_action('wp_ajax_nopriv_get_address_suggestions', [$this, 'handle_ajax_request']);
    }

    // Handle the AJAX request
    public function handle_ajax_request()
    {
        // Create an AddressRequestHandler instance
        $handler = new UAF_Address_Request_Handler($this->address_fetcher, $this->address_suggestion_factory);
        $handler->handle_request();
    }
}
