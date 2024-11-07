<?php

namespace UKAddressFinder\Interfaces;

interface AddressFetcherInterface {
    /**
     * Fetch addresses for a given postal code.
     *
     * @param string $postal_code The postal code to fetch addresses for.
     * @return array The fetched addresses or an error.
     */
    public function fetch_addresses(string $postal_code): array;
}
