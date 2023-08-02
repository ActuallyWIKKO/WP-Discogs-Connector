<?php
// Add plugin settings page
function discogs_collection_folders_settings_page() {
    ?>
    <div class="wrap">
        <h1>Discogs Collection Settings</h1>
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
<p>To display your accounts collection IDs use the shortcode [discogs_collection_folders]
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>