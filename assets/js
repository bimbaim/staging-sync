(function($) {
    // Document ready
    $(document).ready(function() {
        // Your JavaScript code here
        // You can start by targeting specific elements or adding event listeners
        // Example:
        // $('.my-button').on('click', function() {
        //     // Handle button click event
        // });

        // You can also make AJAX requests to interact with the server
        // Example:
        // $.ajax({
        //     url: ajaxurl,
        //     type: 'POST',
        //     data: {
        //         action: 'my_plugin_ajax_action',
        //         // Add any necessary data for the AJAX request
        //     },
        //     success: function(response) {
        //         // Handle AJAX response
        //     },
        //     error: function(xhr, status, error) {
        //         // Handle AJAX error
        //     }
        // });
        
        
             $('#staging-sync-check-connection').click(function() {
            var stagingSiteUrl = $('#staging-site-url').val();

            // Send an AJAX request to check the connection.
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'staging_sync_check_connection',
                    staging_site_url: stagingSiteUrl,
                },
                beforeSend: function() {
                    $('#staging-sync-connection-status').html('<span class="spinner"></span> Checking connection...');
                },
                success: function(response) {
                    if (response === 'success') {
                        $('#staging-sync-connection-status').html('<span class="dashicons dashicons-yes"></span> Connection successful.');
                    } else {
                        $('#staging-sync-connection-status').html('<span class="dashicons dashicons-no"></span> Connection failed.');
                    }
                },
                error: function() {
                    $('#staging-sync-connection-status').html('<span class="dashicons dashicons-no"></span> Connection failed.');
                }
            });
        });
        
        
    });
})(jQuery);
