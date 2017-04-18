<?php
if(!function_exists('theme_shortcode_generator_iframe')){
	function theme_shortcode_generator_iframe(){
		global $sitepress;
		if($sitepress != null){
			$lang = '?lang='.$sitepress->get_current_language();
		}else{
			$lang = '';
		}

		echo '<iframe src="'.THEME_INCLUDES.'/shortcode.php'.$lang.'" class="shortcode_generator_iframe" frameborder="0" width="100%"></iframe>';
	}
}
$config = array(
	'title' => __('Shortcode Generator','striking_admin'),
	'id' => 'shortcode',
	'pages' => theme_get_option('advance','shortcode'),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'high',
);
$options = array(
	array(
		"function" => 'theme_shortcode_generator_iframe',
		"layout" => false,
		"type" => "custom",
	),
);
new metaboxesGenerator($config,$options);

/*
require_once (THEME_HELPERS . '/shortcodesGenerator.php');
function theme_get_image_size(){
	$customs =  theme_get_option('image','customs');
	$sizes = array(
		"small" => __("Small",'striking_admin'),
		"medium" => __("Medium",'striking_admin'),
		"large" => __("Large",'striking_admin'),
	);
	if(!empty($customs)){
		$customs = explode(',',$customs);
		foreach($customs as $custom){
			$sizes[$custom] = ucfirst(strtolower($custom));
		}
	}
	return $sizes;
}

$config = array(
	'title' => __('Shortcode Generator','striking_admin'),
	'id' => 'shortcode',
	'pages' => theme_get_option('advance','shortcode'),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'high',
);
$shortcodes = include(THEME_ADMIN_METABOXES . '/shortcode_options.php');
new shortcodesGenerator($config,$shortcodes);
*/