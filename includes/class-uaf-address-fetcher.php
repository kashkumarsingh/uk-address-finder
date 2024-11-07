<?php

namespace UKAddressFinder;

use UKAddressFinder\Interfaces\AddressFetcherInterface;

class UAF_Address_Fetcher implements AddressFetcherInterface {

    private $api_url = "https://api.ideal-postcodes.co.uk/v1/postcodes/";
    private $api_key = "ak_m377a8p10ShhiKI4AVMRNMuYRaK2e"; // Your API key

    /**
     * Fetch addresses for a given postal code.
     *
     * @param string $postal_code The postal code to fetch addresses for.
     * @return array The fetched addresses or an error message.
     */
    public function fetch_addresses(string $postal_code): array {
        $postal_code = strtoupper(str_replace(' ', '', $postal_code)); // Uppercase and remove spaces
        // Ensure postal code is not empty or invalid
        if (empty($postal_code) || !preg_match('/^[A-Z]{1,2}\d{1,2} ?\d[A-Z]{2}$/i', strtoupper($postal_code))) {
            return ['error' => 'Invalid postal code format.'];
        }

        // Construct the API URL with the postal code and API key
        $url = $this->api_url . urlencode($postal_code) . "?api_key=" . $this->api_key;

        // Perform the API request
        $response = wp_remote_get($url);

        // Check if the response is an error
        if (is_wp_error($response)) {
            return ['error' => 'API request failed: ' . $response->get_error_message()];
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // Log the raw response for debugging
        error_log("API Response: " . print_r($data, true));

        // Check for an error message from the API
        if (isset($data['error'])) {
            return ['error' => 'API error: ' . $data['error']];
        }

        // Check if the API returned a valid result
        if (isset($data['status']) && $data['status'] === 'error') {
            return ['error' => 'API key expired, threshold exceeded, or another API issue.'];
        }

        // Return the results or an empty array if no addresses found
        return isset($data['result']) && is_array($data['result']) ? $data['result'] : [];
    }
}
