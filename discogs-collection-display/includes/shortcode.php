<?php
// Shortcode handler function
function display_discogs_collection_display() {
    // Get username and access token from plugin settings
    $username = get_option( 'discogs_collection_display_username' );
    $access_token = get_option( 'discogs_collection_display_access_token' );
    $error_provide_credentials = '<div id="provide_credentials"><h3>Something is missing</h3><p>Your Discogs username and access token are required to display this content.<br/>Use the plugin options in the backend settings menu to provide them.</p><p>See <a href="https://www.discogs.com/developers" target="_blank" rel="noreferer noopener">Discogs API documentation</a> for more information on how to retrieve a token.</p></div>';
    // Make sure both username and access token are provided
    if ( empty( $username ) || empty( $access_token ) ) {
        return  $error_provide_credentials;
    }

    ob_start(); // Start output buffering

    ?>
    <h3>Discogs Collection Folder IDs</h3>

    <div id="foldersList"></div>

   <script>
    jQuery(document).ready(function($) {
        // Function to copy text to clipboard
        function copyToClipboard(text) {
            var tempInput = $('<input>');
            $('body').append(tempInput);
            tempInput.val(text).select();
            document.execCommand('copy');
            tempInput.remove();
        }

        // Make a GET request to Discogs API to retrieve collection folder ids
        $.ajax({
            url: 'https://api.discogs.com/users/<?php echo esc_js( $username ); ?>/collection/folders',
            type: 'GET',
            headers: {
                'Authorization': 'Discogs token=<?php echo esc_js( $access_token ); ?>'
            },
            success: function (response) {
                // Display the list of folders with IDs
                var userURL = 'https://www.discogs.com/user/<?php echo esc_js( $username ); ?>/collection?folder=';
                var foldersList = response.folders;
                var html = '<ul>';
                foldersList.forEach(function(folder) {
                    // Add a copy button and response message to each folder display
                    var folderId = userURL + folder.id;
                    html += '<li>' + folder.name + ' (ID: ' + folder.id + ')';
                    html += '<button class="copy-btn" data-id="' + folderId + '">Copy</button>';
                    html += '<span class="response-msg" style="display: none;"></span>';
                    html += '</li>';
                });
                html += '</ul>';

                $('#foldersList').html(html);

                // Attach click event to copy buttons
                $('.copy-btn').click(function() {
                    var folderId = $(this).data('id');
                    copyToClipboard(folderId);
                    var responseMsg = $(this).siblings('.response-msg');
                    responseMsg.text(' ID was copied to the clipboard!');
                    responseMsg.show();
                    responseMsg.fadeOut(1500); // Hide the response message after 1.5 seconds
                });
            },
            error: function (xhr, status, error) {
                // Display error message
                $('#foldersList').text('Error: ' + error);
            }
        });
    });
</script>
    <?php

    return ob_get_clean(); // Return the buffer content
}
add_shortcode( 'discogs_collection_display', 'display_discogs_collection_display' );
?>