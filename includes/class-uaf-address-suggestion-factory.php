<?php

namespace UKAddressFinder;

use UKAddressFinder\Interfaces\SuggestionFactoryInterface;

class UAF_Address_Suggestion_Factory implements SuggestionFactoryInterface {

    public function create_suggestions(array $address_data): array {
        $suggestions = [];

        // Check if the address data is valid
        if (!empty($address_data) && is_array($address_data)) {
            foreach ($address_data as $address) {
                // Dynamically construct the address
                $formatted_address = $this->format_address($address);

                // Only add if there's a formatted address
                if ($formatted_address) {
                    $suggestions[] = [
                        'label' => $formatted_address,
                        'value' => $formatted_address,
                    ];
                }
            }
        }

        return $suggestions;
    }

    // Format the address dynamically
    private function format_address(array $address): string {
        // Array to hold different parts of the address
        $address_parts = [];

        // Add address parts if they exist
        if (!empty($address['line_1'])) {
            $address_parts[] = $address['line_1'];
        }
        if (!empty($address['line_2'])) {
            $address_parts[] = $address['line_2'];
        }
        if (!empty($address['post_town'])) {
            $address_parts[] = $address['post_town'];
        }
        if (!empty($address['county'])) {
            $address_parts[] = $address['county'];
        }
        // if (!empty($address['postcode'])) {
        //     $address_parts[] = $address['postcode'];
        // }
        // if (!empty($address['country'])) {
        //     $address_parts[] = $address['country'];
        // }

        // Join the address parts with a comma separator and return
        return implode(', ', $address_parts);
    }
}
