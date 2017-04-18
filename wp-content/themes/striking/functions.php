<?php 
/* Load the Theme class. */
require_once (TEMPLATEPATH . '/framework/theme.php');

$theme = new Theme();
$theme->init(array(
    'theme_name' => 'Striking', 
    'theme_slug' => 'striking'
));

// Add a default avatar to Settings > Discussion
if ( !function_exists('fb_addgravatar') ) {
	function fb_addgravatar( $avatar_defaults ) {
		$myavatar = get_bloginfo('template_directory') . '/images/avatar.png';
		$avatar_defaults[$myavatar] = 'Style';

		return $avatar_defaults;
	}

	add_filter( 'avatar_defaults', 'fb_addgravatar' );
}

// Open Graph Support by Amy Pospiech of Color & Code
function cc_social_sharing_thumbs() {
	
	global $wp_query;
 $thePost = $wp_query->post;
	
	if (has_post_thumbnail( $thePost->ID )) {
		 $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($thePost->ID), array(180,180) );
			$ogimageurl1 = $thumb['0'];
		echo '<meta property="og:image" content="'.$ogimageurl1.'" />';
	}
	if ( function_exists('wpseo_get_value') ) {
		$ogdescription = wpseo_get_value('metadesc');
	} else {
		$ogdescription =	$thePost->post_excerpt;
	}
	
	if ((function_exists('aiosp_meta')) && !(is_home())) {
		// Retrieve description meta data from the SEO Pack
  $ogdescription = stripslashes(get_post_meta($thePost->ID, '_aioseop_description', true));
  // Default description in case none is specified for the page
  if (empty($ogdescription)) $ogdescription = "";
	}

	// Output the html code
	echo '<meta property="og:description" content="'.$ogdescription.'" />';
	$ogurl = get_permalink();
	echo '<meta property="og:url" content="'.$ogurl.'"/>';
};
add_action('wp_head', 'cc_social_sharing_thumbs');






##############################################################
# (1) CPT
##############################################################

function create_media_tax() {
	register_taxonomy(
		'media',
		'press',
		array(
			'label' => __( 'Media Type' ),
			'rewrite' => array( 'slug' => 'media' ),
			'hierarchical' => true,
		)
	);
}
add_action( 'init', 'create_media_tax' );

function register_cpt_press() {

	$labels = array( 
		'name' => _x( 'Press', 'press' ),
		'singular_name' => _x( 'Press Feature', 'press' ),
		'add_new' => _x( 'Add New', 'press' ),
		'add_new_item' => _x( 'Add New Press Feature', 'press' ),
		'edit_item' => _x( 'Edit Item', 'press' ),
		'new_item' => _x( 'New Item', 'press' ),
		'view_item' => _x( 'View Item', 'press' ),
		'search_items' => _x( 'Search Press', 'press' ),
		'not_found' => _x( 'No press items found', 'press' ),
		'not_found_in_trash' => _x( 'No press items found in Trash', 'press' ),
		'parent_item_colon' => _x( 'Parent Item:', 'press' ),
		'menu_name' => _x( 'Press', 'press' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'For press and media features.',
		'supports'				=> array('title', 'thumbnail', 'revisions'),
		'taxonomies' => array( 'Media' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		
		'menu_icon' => '',
		'show_in_nav_menus' => false,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'press', $args );
}
add_action( 'init', 'register_cpt_press' );

add_image_size('thumb-media', 203, 152, true);




##############################################################
# Customize Manage Posts interface
##############################################################

function edit_columns_property($columns){
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Name",
								"taxonomy" => "Media Category",
        "thumbnail" => "Featured Image",
    );
    return $columns;
}
add_filter("manage_edit-press_columns", "edit_columns_property");






##############################################################
# Customize Manage Posts interface
##############################################################


// GET FEATURED IMAGE  
function ST4_get_featured_image($post_ID) {  
				$post_thumbnail_id = get_post_thumbnail_id($post_ID);  
				if ($post_thumbnail_id) {  
								$post_thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, 'full');  
								$site_url = get_bloginfo('template_directory');
								$post_thumbnail_img = $site_url . '/includes/timthumb.php?src='.$post_thumbnail_url[0].'&h=75&w=100&zc=1&a=t';
								return $post_thumbnail_img;
				}  
}  

// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN  
// ADD NEW COLUMN  
function ST4_columns_head_only_cpt($defaults) {  
				$defaults['thumbnail'] = 'Featured';
				$defaults['taxonomy'] = 'Media Type';
				return $defaults;  
}
// SHOW THE FEATURED IMAGE  
function ST4_columns_content_only_cpt($column_name, $post_ID) {  

$add_image_popup = get_bloginfo('url') . '/wp-admin/media-upload.php?post_id='.$post_ID.'&type=image&TB_iframe=1';

	if ($column_name == 'thumbnail') {  
		$post_featured_image = ST4_get_featured_image($post_ID);  
		if ($post_featured_image) {  
						// HAS A FEATURED IMAGE  
						echo '<img src="' . $post_featured_image . '" />';
		} else {  
						// NO FEATURED IMAGE, SHOW THE DEFAULT ONE
						echo "<a id='set-post-thumbnail' class='thickbox' style='color:red; text-decoration:underline;' href='".$add_image_popup."'>Set featured image</a>";
		}
 } 
 if ($column_name == 'taxonomy') {				
	 $terms = get_the_terms( $post_ID, 'media' );
		if ( $terms && ! is_wp_error( $terms ) ) :
		 $custom_tax_media = array();
			foreach ( $terms as $term ) {
				$custom_tax_media[] = $term->name;
			}
			$custom_tax_media = join( ", ", $custom_tax_media );
				echo $custom_tax_media; 
				endif;
	}
}

// Hooks
// ONLY MOVIE CUSTOM TYPE POSTS  
add_filter('manage_press_posts_columns', 'ST4_columns_head_only_cpt', 10);  
add_action('manage_press_posts_custom_column', 'ST4_columns_content_only_cpt', 10, 2);  









function odd_or_even_post_class() {
	global $post_num;

	if ( ++$post_num % 2 )
		$class = 'even';
	else
		$class = 'odd';

	echo $class;
}



/**
 * Add theme support for infinity scroll.
 */
function striking_infinite_scroll_init() {
    add_theme_support( 'infinite-scroll', array(
	    'type'           => 'click',
        'container'      => 'content',
        'footer_widgets' => array( 'sidebar-3', 'sidebar-4', 'sidebar-5', ),
        'footer'         => 'page',
    ) );
}
add_action( 'after_setup_theme', 'striking_infinite_scroll_init' );
