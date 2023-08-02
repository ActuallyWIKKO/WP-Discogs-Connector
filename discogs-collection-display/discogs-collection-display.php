<?php
/**
 * Plugin Name: Discogs Collection Display
 * Plugin URI: wikkedvinyl.com
 * Description: Display your Discogs collection from a specific collection list created on Discogs 
 * Version: 0.0.1
 * Author: WIKKO & Madame A.I.
 * Author URI: wikkedvinyl.com
* This Plugin was written using AI. 
* Basic functionality: Retrieve Discogs Items from the API that are located in a specified list. The settings determine which list ID you are looking for. Once set, the plugin displays all items in the specified list
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
function discogs_collection_display_register_settings() {
    add_option( 'discogs_collection_display_username', '' );
    add_option( 'discogs_collection_display_access_token', '' );
    add_option( 'discogs_collection_display_collectionID', '' );

    register_setting( 'discogs_collection_display_settings_group', 'discogs_collection_display_username' );
    register_setting( 'discogs_collection_display_settings_group', 'discogs_collection_display_access_token' );
    register_setting( 'discogs_collection_display_settings_group', 'discogs_collection_display_collectionID' );
}
add_action( 'admin_init', 'discogs_collection_display_register_settings' );


// Add plugin settings menu item
function discogs_collection_display_add_settings_menu() {
    add_options_page(
        'Discogs Collection Display Settings',
        'Discogs Collection Display',
        'manage_options',
        'discogs_collection_display_settings',
        'discogs_collection_display_settings_page'
    );
}
add_action( 'admin_menu', 'discogs_collection_display_add_settings_menu' );
