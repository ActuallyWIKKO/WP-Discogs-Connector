<?php
/**
 * Plugin Name: Discogs Collection Folders
 * Plugin URI: wikkedvinyl.com
 * Description: Display Discogs collection folders.
 * Version: 0.0.1
 * Author: WIKKO & Madame A.I.
 * Author URI: wikkedvinyl.com
* This Plugin was written using AI. 
* Basic functionality: Retrieve Discogs folder ids and display them using a shortcode.
* Extra functionalities were added to the original plugin, so items (in this case folder ids) retrieved 
* from the discogs API can be copied to the clipboard. The copied ID includes the URL to the folder list 
* on discogs.
 */

// Register plugin settings
function discogs_collection_folders_register_settings() {
    add_option( 'discogs_collection_folders_username', '' );
    add_option( 'discogs_collection_folders_access_token', '' );

    register_setting( 'discogs_collection_folders_settings_group', 'discogs_collection_folders_username' );
    register_setting( 'discogs_collection_folders_settings_group', 'discogs_collection_folders_access_token' );
}
add_action( 'admin_init', 'discogs_collection_folders_register_settings' );

// Enqueue jQuery from the WordPress core
function discogs_collection_folders_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'discogs_collection_folders_enqueue_scripts' );
//Enqueue CSS file(s)
function discogs_collection_folders_enqueue_styles() {
    wp_enqueue_style( 'discogs-collection-folders-style', plugins_url( 'discogs-collection-folders.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'discogs_collection_folders_enqueue_styles' );

// Shortcode handler function
function display_discogs_collection_folders() {
    // Get username and access token from plugin settings
    $username = get_option( 'discogs_collection_folders_username' );
    $access_token = get_option( 'discogs_collection_folders_access_token' );
    $error_provide_credentials = '<div id="provide_credentials"><h3>Something is missing</h3><p>Your Discogs username and access token are required to display this content.<br/>Use the plugin options in the backend settings menu to provide them.</p><p>See <a href="https://www.discogs.com/developers" target="_blank" rel="noreferer noopener">Discogs API documentation</a> for more information on how to retrieve a token.</p></div>';
    // Make sure both username and access token are provided
    if ( empty( $username ) || empty( $access_token ) ) {
        return  $error_provide_credentials;
    }

    ob_start(); // Start output buffering

    ?>
    <h1>Discogs Collection Folder IDs</h1>

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
add_shortcode( 'discogs_collection_folders', 'display_discogs_collection_folders' );

// Add plugin settings page
function discogs_collection_folders_settings_page() {
    ?>
    <div class="wrap">
        <h1>Discogs Collection Settings (Folder IDs)</h1>
        <p>Provide your username and your access token here.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'discogs_collection_folders_settings_group' ); ?>
            <?php do_settings_sections( 'discogs_collection_folders_settings_group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Your Discogs Username:</th>
                    <td><input type="text" name="discogs_collection_folders_username" value="<?php echo esc_attr( get_option( 'discogs_collection_folders_username' ) ); ?>" /><p>The username is case-sensitive.</p></td>
                     </tr> 
                <tr valign="top">
                    <th scope="row">Your Discogs Access Token:</th>
                    <td><input type="text" name="discogs_collection_folders_access_token" value="<?php echo esc_attr( get_option( 'discogs_collection_folders_access_token' ) ); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add plugin settings menu item
function discogs_collection_folders_add_settings_menu() {
    add_options_page(
        'Discogs Collection Folders Settings',
        'Discogs Collection Folders',
        'manage_options',
        'discogs_collection_folders_settings',
        'discogs_collection_folders_settings_page'
    );
}
add_action( 'admin_menu', 'discogs_collection_folders_add_settings_menu' );
