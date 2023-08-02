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

// Include other files
// Include enqueue scripts file
require_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';

// Include enqueue styles file
require_once plugin_dir_path(__FILE__) . 'includes/enqueue-styles.php';

// Include shortcode file
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

// Include settings page file
require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

// Register plugin settings
function discogs_collection_folders_register_settings() {
    add_option( 'discogs_collection_folders_username', '' );
    add_option( 'discogs_collection_folders_access_token', '' );

    register_setting( 'discogs_collection_folders_settings_group', 'discogs_collection_folders_username' );
    register_setting( 'discogs_collection_folders_settings_group', 'discogs_collection_folders_access_token' );
}
add_action( 'admin_init', 'discogs_collection_folders_register_settings' );


// Add plugin settings menu item
function discogs_collection_folders_add_settings_menu() {
    add_options_page(
        'Discogs Collection Settings',
        'Discogs Collection',
        'manage_options',
        'discogs_collection_folders_settings',
        'discogs_collection_folders_settings_page'
    );
}
add_action( 'admin_menu', 'discogs_collection_folders_add_settings_menu' );
