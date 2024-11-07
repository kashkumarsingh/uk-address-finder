import axios from "axios";

/**
 * Utility function to handle address suggestions logic
 * @param {HTMLElement} postalCodeInput - Postal code input field element
 */
export const handleAddressSuggestions = async (postalCodeInput) => {
  const postalCode = postalCodeInput.value;
  const postalCodePattern = /^[A-Z]{1,2}\d{1,2} ?\d[A-Z]{2}$/i; // Basic UK postal code pattern

  // Select form and related elements dynamically
  const form = postalCodeInput.closest("form");
  const addressSuggestions = form
    ? form.querySelector("[data-address-suggestions]")
    : null;
  const manualAddress = form
    ? form.querySelector("[data-manual-address]")
    : null;
  const loadingIndicator = form
    ? form.querySelector("[data-loading-indicator]")
    : null;
  const errorMessage = form
    ? form.querySelector(".error-message") // Select error message element
    : null;

  // Hide suggestions, manual address, and error message initially
  if (addressSuggestions) addressSuggestions.style.display = "none";
  if (manualAddress) manualAddress.style.display = "none";
  if (loadingIndicator) loadingIndicator.style.display = "none";
  if (errorMessage) errorMessage.style.display = "none"; // Hide error message by default

  // Check if postal code format is invalid
  if (!postalCodePattern.test(postalCode)) {
    if (errorMessage) {
      errorMessage.textContent = "Invalid postal code format. Please enter a valid UK postal code.";
      errorMessage.style.display = "block"; // Show error message if postal code is invalid
    }
    return; // Stop further processing
  }

  // Show loading indicator while waiting for the API request
  if (loadingIndicator) loadingIndicator.style.display = "block";

  try {
    const response = await axios.post(
      UKAddressFinder.ajax_url,
      new URLSearchParams({
        action: "get_address_suggestions",
        postal_code: postalCode,
        security: UKAddressFinder.nonce,
      })
    );

    const { success, data } = response.data;

    if (success) {
      if (data.error) {
        console.error("Error fetching suggestions:", data.error);
        if (manualAddress) manualAddress.style.display = "block";
      } else {
        // Handle suggestions display
        if (addressSuggestions) {
          addressSuggestions.innerHTML = ""; // Clear previous suggestions
          data.forEach((suggestion) => {
            const option = document.createElement("option");
            option.value = suggestion.value;
            option.textContent = suggestion.label;
            addressSuggestions.appendChild(option);
          });
          addressSuggestions.style.display = "block";
        }
      }
    } else {
      console.error("API response success=false");
      if (manualAddress) manualAddress.style.display = "block";
    }
  } catch (error) {
    console.error("API request failed", error);
    if (manualAddress) manualAddress.style.display = "block";
  } finally {
    if (loadingIndicator) loadingIndicator.style.display = "none"; // Hide loading indicator after API response
  }
};
