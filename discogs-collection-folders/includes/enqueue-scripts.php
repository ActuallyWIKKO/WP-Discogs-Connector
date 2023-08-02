<?php
// Enqueue jQuery from the WordPress core
function discogs_collection_folders_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'discogs_collection_folders_enqueue_scripts' );
?>