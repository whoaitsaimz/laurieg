<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php theme_generator('title'); ?></title>
<?php if($custom_favicon = theme_get_option('general','custom_favicon')) { ?>
<link rel="shortcut icon" href="<?php echo $custom_favicon; ?>" />
<?php } ?>

<?php wp_head(); ?>

<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400i" rel="stylesheet">

<script type="text/javascript">
var image_url='<?php echo THEME_IMAGES;?>';
</script>
<?php
	if(theme_get_option('general','analytics') && theme_get_option('general','analytics_position')=='header'){
		echo stripslashes(theme_get_option('general','analytics'));
	}
?>
</head>
<body <?php body_class(); ?>>
<header id="header">
	<div class="inner">
<?php if(theme_get_option('general','display_logo')): 
?>
		<div id="logo">
			<a href="<?php echo home_url( '/' ); ?>"><img class="ie_png" src="<?php echo THEME_IMAGES.'/laurieheadersmall2.png'?>" alt="<?php bloginfo('name'); ?>"/></a>
		</div>

		<div id="logo_text">
			<a id="site_name" href="<?php echo home_url( '/' ); ?>"><?php bloginfo('name'); ?></a>
<?php if(theme_get_option('general','display_site_desc')){
		$site_desc = get_bloginfo( 'description' );
		if(!empty($site_desc)):?>
			<div id="site_description"><?php bloginfo( 'description' ); ?></div>
<?php endif;}?>
		</div>
<?php endif; ?>
<?php $top_area_type = theme_get_option('general','top_area_type');
	switch($top_area_type){
		case 'html':
			if(theme_get_option('general','top_area_html')){
				echo '<div id="top_area">';
				echo do_shortcode(wpml_t(THEME_NAME, 'Top Area Html Code', stripslashes( theme_get_option('general','top_area_html') )));
				echo '</div>';
			}
			break;
		case 'wpml_flags':
			theme_generator('wpml_flags');
			break;
		case 'widget':
			echo '<div id="top_area">';
			dynamic_sidebar(__('Header Widget Area','striking_admin'));
			echo '</div>';
			break;
	}
?>
		<?php theme_generator('menu');?>
	</div>
</header>