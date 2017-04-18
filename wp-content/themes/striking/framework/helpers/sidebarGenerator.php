<?php
// Amy's version
class sidebarGenerator {
	
	var $footer_sidebar_count = 0;
	var $sidebars_footer = array();

	function register_sidebar(){		
		
		//register custom sidebars
		
		$sidebars_main = array(
			'sidebar-1'=>__('Homepage Widget Area','striking_admin'),
			'sidebar-2'=>__('Page Widget Area','striking_admin'),
			'sidebar-3'=>__('Blog Widget Area','striking_admin'),
			'sidebar-4' =>__('Press Widget Area','striking_admin'),
		);
		foreach ( $sidebars_main as $id => $sidebar) {
			register_sidebar(
				array (
	            'name'          => $sidebar,
	            'id'            => $id,
	            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	            'after_widget'  => '</aside>',
	            'before_title'  => '<h3 class="widget-title">',
	            'after_title'   => '</h3>',
			    )
		    );
		}
		
		$sidebars_footer = array(
			'sidebar-5'=>'First Footer Widget Area',
			'sidebar-6'=>'Second Footer Widget Area',
			'sidebar-7'=>'Third Footer Widget Area',
			'sidebar-8' =>'Fourth Footer Widget Area',
			'sidebar-9' =>'Fifth Footer Widget Area',
			'sidebar-10' =>'Sixth Footer Widget Area',
		);
		foreach ( $sidebars_footer as $id => $sidebar) {
			register_sidebar(
				array (
	            'name'          => __( $sidebar, 'striking_admin' ),
	            'id'            => $id,
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<h5 class="widgettitle">',
				'after_title' => '</h5>',
			    )
		    );
		}
		
		$top_area_type = theme_get_option('general','top_area_type');
		if($top_area_type == 'widget'){
			register_sidebar(array(
				'name' =>  __('Header Widget Area','striking_admin'),
				'id' => 'sidebar-11',
				'description' => __('Header Widget Area','striking_admin'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '',
				'after_title' => '',
			));
		}
			
		$footer_right_area_type = theme_get_option('footer','footer_right_area_type');
		if($footer_right_area_type == 'widget'){
			register_sidebar(array(
				'name' =>  __('Sub Footer Widget Area','striking_admin'),
				'id' => 'sidebar-12',
				'description' => __('Sub Footer Widget Area','striking_admin'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '',
				'after_title' => '',
			));
		}
		
		$custom_sidebars = theme_get_option('sidebar','sidebars');
		if(!empty($custom_sidebars)){
			$custom_sidebar_names = explode(',',$custom_sidebars);
			foreach ($custom_sidebar_names as $id => $name){
				register_sidebar(array(
					'name' =>  $name,
					'description' => __('A custom sidebar','striking_admin'),
					'id' =>  $id,
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget' => '</section>',
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => '</h3>',
				));
			}
		}
		
	}
	
	function get_sidebar($post_id){
		if(is_page()){
			$sidebar = 'sidebar-2';
		}
		if(is_front_page() || $post_id == theme_get_option('homepage','home_page') ){
			$home_page_id = theme_get_option('homepage','home_page');
			$post_id = wpml_get_object_id($home_page_id,'page');
			$sidebar = 'sidebar-1';
		}
		if(is_blog()){
			$sidebar = 'sidebar-3';
		}
		if(is_singular('post')){
			$sidebar = 'sidebar-3';
		}elseif(is_singular('portfolio')){
			$sidebar = 'sidebar-4';
		}
		if(is_search() || is_archive()){
			$sidebar = 'sidebar-3';
		}
		
		if(!empty($post_id)){
			$custom = get_post_meta($post_id, '_sidebar', true);
			if(!empty($custom)){
				$sidebar = $custom;
			}
		}
		if(isset($sidebar)){
			dynamic_sidebar($sidebar);
		}
	}
}
global $_sidebarGenerator;
$_sidebarGenerator = new sidebarGenerator;

add_action('widgets_init', array($_sidebarGenerator,'register_sidebar'));

function sidebar_generator($function){
	global $_sidebarGenerator;
	$args = array_slice( func_get_args(), 1 );
	return call_user_func_array(array( &$_sidebarGenerator, $function ), $args );
}