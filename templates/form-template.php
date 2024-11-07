<?php
/**
 * Form Template for Address Finder
 */
?>

<form id="uk-address-finder-form" class="uk-address-finder-form" method="post" action="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>">
    <label for="postal-code">Postal Code:</label>
    <input type="text" id="postal-code" name="postal_code" data-postal-code placeholder="Enter Postal Code" required>

    <!-- Error Message for Postal Code -->
    <div class="error-message" style="color: red; display: none;" aria-live="polite"></div>

    <div class="address-suggestions-container">
        <label for="address-suggestions">Suggested Addresses:</label>
        <select id="address-suggestions" name="address_suggestions" data-address-suggestions style="display: none;" aria-labelledby="address-suggestions">
            <!-- Address options will be dynamically inserted here -->
        </select>

        <div id="manual-address" data-manual-address style="display: none;">
            <label for="manual-address-input">Enter Address Manually:</label>
            <input type="text" id="manual-address-input" name="manual_address" placeholder="Enter full address">
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loading-indicator" data-loading-indicator style="display: none;">
        <p>Loading...</p>
    </div>

    <?php 
    // Add a nonce field for security if using AJAX for form submission
    wp_nonce_field( 'uk_address_finder_nonce_action', 'uk_address_finder_nonce_field' );
    ?>
</form>
