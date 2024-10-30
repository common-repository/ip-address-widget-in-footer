<?php
/**
 * Plugin Name: IP Address Widget in Footer
 * Plugin URI: https://ipaddress.tech/widgets
 * Description: This plugin allows you to insert IP Address widget code in footer section of the theme. This plugin calls ipaddress.tech widget (https://ipaddress.tech/widgets) which is basically an image (what-is-my-ip-address.png). When browser access this image, It detects its public IP Address and generate the image dynamically. You can change widget image background from admin setting area.
 * Version: 1.0.0
 * Author: Farooq Sheikh
 * Author URI: https://ipaddress.tech
 */


function ipwf_ipaddress_footer_widget(){

if(!get_option('ipwf-ipfoot-img-scr')){
    update_option('ipwf-ipfoot-img-scr', 'what-is-my-ip-address.png');
}
echo "<div class=\"ipaddress site-footer\" >\n";
echo "  <a href=\"https://ipaddress.tech\"><img src=\"https://ipaddress.tech/" . get_option('ipwf-ipfoot-img-scr') . "\" alt=\"What is My IP Address?\" title=\"What is My IP Address?\"> </a>\n";
echo "</div>\n";
echo "<style>\n";
echo "  body {\n";
echo "    position: relative;\n";
echo "  }\n";
echo "  .ipaddress {\n";
echo "    position: absolute;\n";
echo "    bottom: 8px;\n";
echo "    right: 0;\n";
echo "    z-index: 9999999999999999999;\n";
echo "  }\n";
echo "  @media (max-width: 1024px) {\n";
echo "    .ipaddress {\n";
echo "      Position: static;\n";
echo "      bottom: 8px;\n";
echo "      right: 0;\n";
echo "      z-index: 9999999999999999999;\n";
echo "      background: #333333;\n";
echo "      text-align: center;\n";
echo "      padding: 5px 0;\n";
echo "    }\n";
echo "  }\n";
echo "</style>";
}
add_action('wp_footer', 'ipwf_ipaddress_footer_widget');


function ipwf_ip_ins_scr() {

if(isset($_POST['ipsub'])){

$retrieved_nonce = $_REQUEST['_wpnonce'];
if (!wp_verify_nonce($retrieved_nonce, 'ipwf_save_action' ) ) die( 'Failed security check' );

	add_option('ipwf-ipfoot-img-scr', stripslashes($_POST['ipwf-ipfoot-img']), '', 'yes' );

	
	$ipft_img_scr = get_option('ipwf-ipfoot-img-scr');
	if($ipft_img_scr!="" || $ipft_img_scr==NULL){
	 update_option('ipwf-ipfoot-img-scr', stripslashes($_POST['ipwf-ipfoot-img']));
	}

	
}
?>
<form method="post" action="">
<fieldset style="border:1px solid #000; width:90%; margin-top:20px; padding:10px;">
<legend style="font-size:16px; font-weight:700;">Insert IP Address Widget Code in Footer section of your WordPress site </legend>
<table cellpadding="10" cellspacing="10">
<tr><td width:"25%" valign="top"><h3>Widget Background</h3></td>
<td>
<?php wp_nonce_field('ipwf_save_action'); ?>
<input name="ipwf-ipfoot-img" type="radio" value="what-is-my-ip-address.png" <?php checked( 'what-is-my-ip-address.png', get_option( 'ipwf-ipfoot-img-scr' ) ); ?> />Black <img src="https://ipaddress.tech/what-is-my-ip-address.png"><br>
<input name="ipwf-ipfoot-img" type="radio" value="what-is-my-ip-address-w.png" <?php checked( 'what-is-my-ip-address-w.png', get_option( 'ipwf-ipfoot-img-scr' ) ); ?> />White <img src="https://ipaddress.tech/what-is-my-ip-address-w.png"><br>
</td></tr>
<tr><td colspan="2"><input type="submit" id="ipsub" name="ipsub" value="Save"/></td></tr>
</table>
</fieldset>
</form>
<?php
}

function ipwf_insert_widget_scripts() {

 add_options_page('IP Address Widget', 'IPAddress.Tech Widget', 'manage_options', 'ipwf-ip-ins-scr', 'ipwf_ip_ins_scr');

}
add_action('admin_menu', 'ipwf_insert_widget_scripts');
