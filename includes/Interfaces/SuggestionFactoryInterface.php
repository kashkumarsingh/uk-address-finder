<?php

namespace UKAddressFinder\Interfaces;

interface SuggestionFactoryInterface {
    /**
     * Create suggestions from the provided address data.
     *
     * @param array $address_data The raw address data fetched from the API.
     * @return array An array of suggestions.
     */
    public function create_suggestions(array $address_data): array;
}
