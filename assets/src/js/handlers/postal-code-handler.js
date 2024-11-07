// postal-code-handler.js

import { handleAddressSuggestions } from '../services/address-suggestions';  // Correct path from handlers to services


/**
 * Attach event listeners to postal code input fields
 */
document.addEventListener('DOMContentLoaded', () => {
    // Select all postal code input fields
    const postalCodeInputs = document.querySelectorAll('[data-postal-code]');

    postalCodeInputs.forEach(postalCodeInput => {
        postalCodeInput.addEventListener('input', () => handleAddressSuggestions(postalCodeInput));
    });
});
