<?php
//Enqueue CSS file(s)
function discogs_collection_display_enqueue_styles() {
    wp_enqueue_style( 'discogs-collection-display-style', plugins_url( 'includes/CSS/discogs-collection-display.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'discogs_collection_display_enqueue_styles' );
?>