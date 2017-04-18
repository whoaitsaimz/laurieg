<?php

get_header();
?>
	  
  

<div id="feature">
	<div class="top_shadow"></div>
	<div class="inner"><h1>Recent TV & Event Appearances</h1></div>
	<div class="bottom_shadow"></div>
</div>

<div id="page">
	<div class="inner fullwidth">
		<div id="main">
			<div class="content">
			<?php //for a given post type, return all
				$tax = 'media';
				$tax_terms = get_terms('media');
				
				foreach ($tax_terms  as $tax_term) {
					$args = array(
						'post_type' => 'press',
						'media' => $tax_term->slug,
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'ignore_sticky_posts'=> 1,
						'order' => 'DESC',
					);
					$my_query = null;
					$my_query = new WP_Query($args);
					if( $my_query->have_posts() ) {
						echo '<div class="clearboth"></div>';
						echo '<h2 class="press-taxonomy">'. $tax_term->name . '</h2>';
						
						while ($my_query->have_posts()) : $my_query->the_post(); ?>
      
				       <div class="press-item">    
				        <?php 
				        $lightbox_title = get_field('lightbox_title');
				        $lightbox_href = get_field('lightbox_href');
				        $lightbox_width = get_field('lightbox_width');
				        $lightbox_height = get_field('lightbox_height');
				        if ( has_post_thumbnail($post->ID) ) {
				         $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumb-media' );
				         $height_1x = 152;
				         $width_1x = 203;
				         $image_src = get_image_src($thumb[0]);
				        } else {
				         $image_src = get_stylesheet_directory_uri()."/images/press-noimage.png"; 
				        }
				        
				        echo '<a class="various fancybox.iframe" title="'.$lightbox_title.'" href="'.$lightbox_href.'" rel="1" data-fancybox-width="'.$lightbox_width.'" data-fancybox-height="'.$lightbox_height.'"><img class="size-full thumb-media" src="'.$image_src.'" alt="'.get_the_title().'"></a>';
				        ?>
				        <br/>
				        <h5><?php the_title(); ?></h5>
				       </div> <!-- end press-item -->

						<?php 
						endwhile;	
					}
					wp_reset_query();
				} // end foreach  ?>
				<div class="clearboth"></div>
			</div><! -- end content -->
		</div><! -- end main -->
		<div class="clearboth"></div>
	</div><! -- end inner -->
	<div id="page_bottom"></div>
</div><! -- end page -->
<?php get_footer(); ?>

<script type="text/javascript">
$(document).ready(function() {
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		autoSize : false,
		beforeLoad : function() {         
            this.width  = parseInt(this.element.data('fancybox-width'));  
            this.height = parseInt(this.element.data('fancybox-height'));
        }
	});
});
</script>