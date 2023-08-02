<?php
// Add plugin settings page
function discogs_collection_display_settings_page() {
    ?>
    <div class="wrap">
        <h1>Discogs Collection Display Settings</h1>
        <p>Provide your username and your access token here.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'discogs_collection_display_settings_group' ); ?>
            <?php do_settings_sections( 'discogs_collection_display_settings_group' ); ?>
            <fieldset class="form-table">
                  <label for="discogsUsername">Your Discogs Username:</label>
                  <input type="text" name="discogs_collection_display_username" value="<?php echo esc_attr( get_option( 'discogs_collection_display_username' ) ); ?>" /><p>The username is case-sensitive.</p>
                <tr valign="top">
                    <th scope="row">Your Discogs Access Token:</th>
                    <td><input type="text" name="discogs_collection_display_access_token" value="<?php echo esc_attr( get_option( 'discogs_collection_display_access_token' ) ); ?>" /><p>To display your accounts collection IDs use the shortcode [discogs_collection_display]</p></td>

                </tr>
                <tr valign="top">
                    <th scope="row">Your Discogs Collection ID:</th>
                    <td><input type="text" name="discogs_collection_display_access_token" value="<?php echo esc_attr( get_option( 'discogs_collection_display_collectionID' ) ); ?>" /></td>
                </tr>
</fieldset>
            <?php submit_button(); ?>
        </form>
        <form method="post" action="options.php"> 
        <?php settings_fields( 'discogs_collection_folder_settings_group' ); ?>
            <?php do_settings_sections( 'discogs_collection_folder_settings_group' ); ?>
            <p>Display my collection IDs:</p>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>