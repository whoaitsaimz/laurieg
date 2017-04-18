<?php 
/**
 * JavaScripts In Header
 */
function theme_enqueue_scripts() {
	if(is_admin() || 'wp-login.php' == basename($_SERVER['PHP_SELF'])){
		return;
	}
	
	$move_bottom = theme_get_option('advance','move_bottom');
	
	wp_deregister_script('jquery');
	wp_register_script( 'jquery', 'https://code.jquery.com/jquery-1.8.3.min.js',false, '1.8.3');
	//wp_register_script( 'jquery', THEME_JS .'/jquery-1.4.4.min.js',false, '1.4.4');
	//wp_enqueue_script( 'jqueryslidemenu', THEME_JS .'/jqueryslidemenu.js', array('jquery'),false,$move_bottom);
	//wp_enqueue_script( 'jquery-tools-tabs', THEME_JS .'/jquery.tools.tabs.min.js', array('jquery'),'1.2.5',$move_bottom);
	//wp_enqueue_script( 'jquery-colorbox', THEME_JS .'/jquery.colorbox-min.js', array('jquery'),'1.3.17.1',$move_bottom);
	//wp_enqueue_script( 'jquery-swfobject', THEME_JS .'/jquery.swfobject.1-1-1.min.js', array('jquery'),'1.1.1',$move_bottom);
	//wp_enqueue_script( 'videojs', THEME_JS .'/video.js', array('jquery'),'2.0.2',$move_bottom);
	wp_enqueue_script( 'custom-js', THEME_JS .'/custom.min.js', array('jquery'),false,$move_bottom);
	
	//wp_register_script('jquery-nivo', THEME_JS . '/jquery.nivo.slider.pack.js', array('jquery'),'2.6',$move_bottom);
	//wp_register_script('jquery-easing', THEME_JS . '/jquery.easing.1.3.js', array('jquery'),'1.3',$move_bottom);
	//wp_register_script('jquery-kwicks', THEME_JS . '/jquery.kwicks-1.5.1.pack.js', array('jquery'),'1.5.1',$move_bottom);
	//wp_register_script('jquery-anything', THEME_JS . '/jquery.anythingslider.js', array('jquery'),'1.6.2',$move_bottom);
	
	//wp_register_script( 'cufon-yui', THEME_JS .'/cufon-yui.js', array('jquery'),'1.09i');
	//wp_register_script( 'jquery-quicksand', THEME_JS .'/jquery.quicksand.js', array('jquery'),'1.2.2');
	//wp_register_script( 'jquery-gmap', THEME_JS .'/jquery.gmap-1.1.0-min.js', array('jquery'),'1.1.0');
	//wp_register_script( 'jquery-tweet', THEME_JS .'/jquery.tweet.js', array('jquery'));
	//wp_register_script( 'jquery-tools-validator', THEME_JS .'/jquery.tools.validator.min.js', array('jquery'),'1.2.5');
	if( is_front_page() || is_home() || is_single() || is_page() ){
		theme_generator('slideShowHeader');
	}
	
	if ( is_singular() ){
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_print_scripts', 'theme_enqueue_scripts');

function theme_enqueue_styles(){
	if(is_admin() || 'wp-login.php' == basename($_SERVER['PHP_SELF'])){
		return;
	}
	//wp_enqueue_style('theme-style', THEME_URI.'/styles/styles.php', false, false, 'all');
	wp_enqueue_style('theme-style', THEME_CSS.'/style.css', false, false, 'all');
}
add_action('wp_print_styles', 'theme_enqueue_styles');


require_once (THEME_PLUGINS . '/Browser.php');
$browser = new Browser();
if($browser->isMobile()){
	add_action('wp_head', 'theme_add_viewport_meta');
	function theme_add_viewport_meta() {
		echo "\n" . '<meta name="viewport" content="width=1100" />' . "\n";
	}
}

