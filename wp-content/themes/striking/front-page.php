<?php
get_header();
global $home_page_id;
global $content;
$home_page_id = theme_get_option('homepage','home_page');

if($home_page_id){
	$home_page_id = wpml_get_object_id($home_page_id,'page');
	theme_generator('introduce',$home_page_id);
}else{
	if (!theme_get_option('homepage', 'disable_slideshow')) {
		$type = theme_get_option('homepage', 'slideshow_type');
		$category = theme_get_option('homepage', 'slideshow_category');
		$number = theme_get_option('homepage', 'slideshow_number');
		theme_generator('slideShow',$type,$category,'',$number);
	}
	$content = theme_get_option('homepage','page_content');
}
$layout='left';
?>
<div id="page" class="home">
	<div class="inner left_sidebar">
		<div id="main">
			<div class="content">
				<div class="content">
				<?php 
					$exclude_cats = theme_get_option('blog','exclude_categorys');
					foreach ($exclude_cats as $key => $value) {
						$exclude_cats[$key] = -$value;
					}
					if(stripos($query_string,'cat=') === false){
						query_posts($query_string."&cat=".implode(",",$exclude_cats));
					}else{
						query_posts($query_string.implode(",",$exclude_cats));
					}
					get_template_part('content','archive');
				?>
					<div class="clearboth"></div>
				</div>
				<nav class="entry_navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'striking_front' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'striking_front' ) . '</span>' ); ?></div>
				</nav>

				<div class="clearboth"></div>
				
				<!-- was facebook widget
				<div id="bottomContent">
				</div>
				<div class="clearboth"></div> -->
   
				<?php echo apply_filters('the_content', stripslashes( $content ));?>
				<div class="clearboth"></div>
			</div><!-- end .content -->
		</div><!-- end #main -->
		<?php if($layout != 'full') get_sidebar(); ?>
		<div class="clearboth"></div>
	</div><!-- end .inner -->
	<div id="page_bottom"></div>
</div><!-- end #page -->
<?php get_footer(); ?>