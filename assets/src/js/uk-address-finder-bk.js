import axios from 'axios';

/**
 * Utility function to handle address suggestions logic
 * @param {HTMLElement} postalCodeInput - Postal code input field element
 */
const handleAddressSuggestions = async (postalCodeInput) => {
    const postalCode = postalCodeInput.value;
    const postalCodePattern = /^[A-Z]{1,2}\d{1,2} ?\d[A-Z]{2}$/i;
    
    // Select form and related elements dynamically
    const form = postalCodeInput.closest('form');
    const addressSuggestions = form.querySelector('[data-address-suggestions]');
    const manualAddress = form.querySelector('[data-manual-address]');

    // Hide suggestions and manual address initially
    addressSuggestions.style.display = 'none';
    manualAddress.style.display = 'none';

    if (!postalCodePattern.test(postalCode)) {
        return; // Do nothing if the postal code is invalid
    }

    try {
        // Make API request for address suggestions
        const response = await axios.post(UKAddressFinder.ajax_url, {
            action: 'get_address_suggestions',
            postal_code: postalCode
        });

        const { success, data } = response.data;

        // Handle the response data
        if (success) {
            if (data.error) {
                manualAddress.style.display = 'block'; // Show manual address if there's an error (e.g., API key issue)
            } else {
                // Clear existing suggestions and populate new ones
                addressSuggestions.innerHTML = '';
                data.forEach(suggestion => {
                    const option = document.createElement('option');
                    option.value = suggestion.value;
                    option.textContent = suggestion.label;
                    addressSuggestions.appendChild(option);
                });
                addressSuggestions.style.display = 'block'; // Show address suggestions
            }
        } else {
            manualAddress.style.display = 'block'; // Show manual address if API response is not successful
        }
    } catch (error) {
        console.error('API request failed', error); // Log error for debugging
        manualAddress.style.display = 'block'; // Show manual address on error
    }
};

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
