<?php
//Enqueue CSS file(s)
function discogs_collection_folders_enqueue_styles() {
    wp_enqueue_style( 'discogs-collection-folders-style', plugins_url( 'includes/CSS/discogs-collection-folders.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'discogs_collection_folders_enqueue_styles' );
?>