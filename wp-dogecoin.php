<?php
/*
Plugin Name: WP-DogeCoin
Plugin URI: http://www.studionashvegas.com/plugins/wp-dogecoin
Description: This plugin allows you to add your Dogecoin donation address to the bottom of your blog posts - automatically!
Version: 1.1
Author: Mitch Canter
Author URI: http://www.studionashvegas.com
Author Email: mitch@studionashvegas.com
License: GPL 3.0
License URI: http://www.gnu.org/licenses/gpl.html
*/

// Adds the wallet address to the end of the post content.
add_filter ('the_content', 'WPDogeCoinContent');

function WPDogeCoinContent($content) {
	if (get_option('wpdc_wallet_address') == true) {
		$content .= '<div class="wpdc_box">';
		$content .= 'Donate Dogecoins: <strong>';
		$content .= get_option('wpdc_wallet_address');
		$content .= '</strong> ';
		$content .= '<span class="wpdc_small"><a href="http://dogecoin.com/" target="_blank">Whats This?</a></span>';
		$content .= '</div>';
		return $content;
	} else {
		return $content;
	}
}

// stylesheet for the donation bar
    add_action( 'wp_enqueue_scripts', 'safely_add_stylesheet' );
    
    function safely_add_stylesheet() {
        wp_enqueue_style( 'wp-dogecoin', plugins_url('wp-dogecoin.css', __FILE__) );
    }
// create custom plugin settings menu
add_action('admin_menu', 'wpdc_create_menu');

function wpdc_create_menu() {

	//create new top-level menu
	add_menu_page('WPDC Plugin Settings', 'WPDC Settings', 'administrator', __FILE__, 'wpdc_settings_page',plugins_url('/wp-dogecoin-icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'wpdc-settings-group', 'wpdc_wallet_address' );
}

function wpdc_settings_page() {
?>
<div class="wrap">
<h2>WP-Dogecoin Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'wpdc-settings-group' ); ?>
    <?php do_settings_sections( 'wpdc-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Wallet Address</th>
        <td><input type="text" name="wpdc_wallet_address" value="<?php echo get_option('wpdc_wallet_address'); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>

<p>Plugin written and supported by <a href="http://www.studionashvegas.com" target="_blank">Mitch Canter</a>.  You can send donations to <strong>D5Lfoc5TXwopvLeMnJxBswV8iEY5t4dTuz</strong> if you like what you see!</p>
</div>
<?php } ?>
