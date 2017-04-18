<?php

define('WP_ADMIN', true);

require_once( '../../../../wp-load.php' );
require_once('../../../../wp-admin/includes/admin.php');

nocache_headers();

do_action('admin_init');

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php do_action('admin_xml_ns'); ?> <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<title><?php _e( 'Shortcode Generator' ) ?></title>
<?php
wp_admin_css( 'global' );
wp_admin_css();
wp_admin_css( 'colors' );
wp_admin_css( 'ie' );
if ( is_multisite() )
	wp_admin_css( 'ms' );
	
function shortcode_enqueue_scripts() {
	wp_enqueue_script('utils');
	wp_enqueue_script('shortcode',THEME_ADMIN_ASSETS_URI . '/js/shortcode.js',array('jquery'));
	wp_enqueue_script('jquery-tools-rangeinput',THEME_ADMIN_ASSETS_URI . '/js/rangeinput.js',array('jquery'),'1.2.5');
	wp_enqueue_script('iphone-style-checkboxes',THEME_ADMIN_ASSETS_URI . '/js/iphone-style-checkboxes.js',array('jquery'));
	wp_enqueue_script('iphone-style-tri-toggle',THEME_ADMIN_ASSETS_URI . '/js/iphone-style-tri-toggle.js',array('jquery'));
	wp_enqueue_script('jquery-tools-validator',THEME_ADMIN_ASSETS_URI . '/js/validator.js',array('jquery'),'1.2.5');
	wp_enqueue_script('theme-script', THEME_ADMIN_ASSETS_URI . '/js/script.js');
	wp_enqueue_script('mColorPicker',THEME_ADMIN_ASSETS_URI . '/js/mColorPicker.js',array('jquery'),'1.0 r34');
}
add_action( 'admin_enqueue_scripts', 'shortcode_enqueue_scripts' );
	


global $hook_suffix;
do_action('admin_enqueue_scripts', $hook_suffix);
do_action("admin_print_styles-$hook_suffix");
do_action('admin_print_styles');
do_action("admin_print_scripts-$hook_suffix");
do_action('admin_print_scripts');
do_action("admin_head-$hook_suffix");
do_action('admin_head');
?>
<style type="text/css">
html {
	overflow:hidden;
	background-color: #FFFFFF;
}
.theme-options-table td, .theme-options-table th {
    font-size: 11px;
}
</style>

<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
jQuery(document).ready(function(){
	jQuery('a.thickbox').live('click', function(){
		var t = this.title || this.name || null;
		var a = this.href || this.alt;
		var g = this.rel || false;
		//tb_show(t,a,g);
		var win = window.dialogArguments || opener || parent || top;
		win.tb_show(t,a,g);
		this.blur();
		return false;
	});
});
</script>

</head>
<body>
<div id="wpcontent">
<?php
require_once (THEME_HELPERS . '/shortcodesGenerator.php');

$shortcodes = include(THEME_ADMIN_METABOXES . '/shortcode_options.php');

new shortcodesGenerator($shortcodes);
?>
</div>
</body>
</html>