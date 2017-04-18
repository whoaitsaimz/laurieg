<?php
if (! function_exists("theme_advance_reset_options_process")) {
	function theme_advance_reset_options_process($option,$data) {
		if(is_array($data)){
			foreach($data as $page){
				delete_option(THEME_SLUG . '_' . $page);
			}
		}
		return false;
	}
}
if (! function_exists("theme_advance_import_option")) {
	function theme_advance_import_option($value, $default) {
		$rows = isset($value['rows']) ? $value['rows'] : '5';
		echo '<textarea id="'.$value['id'].'" rows="' . $rows . '" name="' . $value['id'] . '" type="' . $value['type'] . '" class="code">';
		echo $default;
		echo '</textarea><br />';
		echo '</td></tr>';
	}
}
if (! function_exists("theme_advance_export_option")) {
	function theme_advance_export_option($value, $default) {
		global $theme_options;
		$rows = isset($value['rows']) ? $value['rows'] : '5';
		echo '<textarea id="'.$value['id'].'" rows="' . $rows . '" name="' . $value['id'] . '" type="' . $value['type'] . '" class="code">';
		echo base64_encode(serialize($theme_options));
		echo '</textarea><br />';
		echo '</td></tr>';
	}
}
if (! function_exists("theme_advance_export_process")) {
	function theme_advance_export_process($option,$data) {
		return '';
	}
}
if (! function_exists("theme_advance_import_process")) {
	function theme_advance_import_process($option,$data) {
		if($data != ''){
			
			$options_array = unserialize( base64_decode( $data ) );
			if(is_array($options_array)){
				foreach($options_array as $name => $options){
					update_option(THEME_SLUG . '_' . $name, $options);
				}
			}
		}
		return '';
	}
}
if (! function_exists("theme_advance_updating_portfolio_more_process")) {
	function theme_advance_updating_portfolio_more_process($option,$data) {
		if($data == true){
			$entries = get_posts('post_type=portfolio&meta_key=_more&meta_value=-1');
			foreach($entries as $entry) {
				update_post_meta($entry->ID, '_more', 'false');
			}
			
			$entries = get_posts('post_type=portfolio&meta_key=_more&meta_value=true');
			foreach($entries as $entry) {
				update_post_meta($entry->ID, '_more', '');
			}
		}
		return false;
	}
}
$options = array(
	array(
		"name" => __("Advanced",'striking_admin'),
		"type" => "title"
	),
	
	array(
		"name" => __("General",'striking_admin'),
		"type" => "start"
	),
		array(
			"name" => __("Reset Theme Options",'striking_admin'),
			"id" => "rest",
			"default" => array(),
			"desc" => __('If you want reset your theme options to defualt, please checked the items below.','striking_admin'),
			"options" => array(
				"general" => __('General','striking_admin'),
				"background" => __('Background','striking_admin'),
				"color" => __('Color','striking_admin'),
				"font" => __('Font','striking_admin'),
				"cufon" => __('Cufon','striking_admin'),
				"fontface" => __('Fontface','striking_admin'),
				"slideshow" => __('SlideShow','striking_admin'),
				"sidebar" => __('Sidebar','striking_admin'),
				"image" => __('Image','striking_admin'),
				"video" => __('Video','striking_admin'),
				"homepage" => __('Homepage','striking_admin'),
				"blog" => __('Blog','striking_admin'),
				"portfolio" => __('Portfolio','striking_admin'),
				"footer" => __('Footer','striking_admin'),
			),
			"process" => "theme_advance_reset_options_process",
			"type" => "checkboxs",
		),
	array(
		"type" => "end"
	),
	
	array(
		"name" => __("Import & Export",'striking_admin'),
		"type" => "start"
	),
		array(
			"name" => sprintf(__("Import %s Options Data",'striking_admin'),THEME_NAME),
			"id" => "import",
			"desc" => __('To import the values of your theme options copy and paste what appears to be a random string of alpha numeric characters into this textarea and press the "Save Changes" button below.','striking_admin'),
			"function" => "theme_advance_import_option",
			"process" => "theme_advance_import_process",
			"type" => "custom"
		),
		array(
			"name" => sprintf(__("Export %s Options Data",'striking_admin'),THEME_NAME),
			"id" => "export",
			"desc" => __("Export your saved Theme Options data by highlighting this text and doing a copy/paste into a blank .txt file.",'striking_admin'),
			"function" => "theme_advance_export_option",
			"process" => "theme_advance_export_process",
			"type" => "custom"
		),
	array(
		"type" => "end"
	),
	array(
		"name" => __("Meta Box display Settings",'striking_admin'),
		"type" => "start"
	),
		array(
			"name" => __("Page General Options",'striking_admin'),
			"id" => "page_general",
			"default" => array('post','page','portfolio'),
			"target" => 'post_types',
			"type" => "checkboxs",
		),
		array(
			"name" => __("Shortcode Generator",'striking_admin'),
			"id" => "shortcode",
			"default" => array('page','post','portfolio','slideshow'),
			"target" => 'post_types',
			"type" => "checkboxs",
		),
	array(
		"type" => "end"
	),
	array(
		"name" => __("JavaScript & CSS Optimizer",'striking_admin'),
		"type" => "start"
	),
		array(
			"name" => __("Combine Js",'striking_admin'),
			"id" => "combine_js",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Combine CSS",'striking_admin'),
			"id" => "combine_css",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Move Js To Bottom",'striking_admin'),
			"id" => "move_bottom",
			"default" => false,
			"type" => "toggle"
		),
	array(
		"type" => "end"
	),
		array(
		"name" => __("Updating fix",'striking_admin'),
		"type" => "start"
	),
		array(
			"name" => __("Portfolio Item Module 'Enable Read More' option fix",'striking_admin'),
			"id" => "updating_portfolio_more",
			"desc" =>  __("Fix 'Enable Read More' option on Portfolio Item Module issue after updating < version 3.0.1 to the new one. Do not try this if it's a new installation. You only need to enable this once."),
			"default" => false,
			"process" => "theme_advance_updating_portfolio_more_process",
			"type" => "toggle"
		),
	array(
		"type" => "end"
	),
);
return array(
	'auto' => true,
	'name' => 'advance',
	'options' => $options
);