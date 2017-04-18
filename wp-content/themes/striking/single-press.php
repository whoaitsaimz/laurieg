<?php
$blog_page = theme_get_option('blog','blog_page');
if($blog_page == $post->ID){
	return require(THEME_DIR . "/template_blog.php");
}
?>

<?php  get_header(); ?>
<?php theme_generator('introduce',$post->ID);?>
<div id="page">
	<div class="inner">
		<div id="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" class="entry content">

    <div class="press-item">    
        <?php 
        $lightbox_title = get_field('lightbox_title');
        $lightbox_href = get_field('lightbox_href');
        $lightbox_width = get_field('lightbox_width');
        $lightbox_height = get_field('lightbox_height');
        if ( has_post_thumbnail($post->ID) ) {
         $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumb-media' );
         $lightbox_thumb_url = $thumb['0']; 
        } else {
         $lightbox_thumb_url = "no-image.jpg"; 
        }		
          
        echo do_shortcode('[lightbox title="'.$lightbox_title.'" href="'.$lightbox_href.'" width="'.$lightbox_width.'" height="'.$lightbox_height.'" iframe="true" group="1"]<img class="size-full thumb-media" src="'.$lightbox_thumb_url.'" alt="'.get_the_title().' Feature" />[/lightbox]');
        ?>
        <br/>
        <h5><?php the_title(); ?></h5>
    </div>    
    
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'striking_front' ), 'after' => '</div>' ) ); ?>
				<footer>
				<?php edit_post_link(__('Edit', 'striking_front'),'<p class="entry_edit">','</p>'); ?>
    
<?php if(theme_get_option('portfolio','single_navigation')):?>
					<nav class="entry_navigation">
						<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous', 'striking_front' ) . '</span> %title' ); ?></div>
						<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next', 'striking_front' ) . '</span>' ); ?></div>
					</nav>
<?php endif;?>
				</footer>
				<div class="clearboth"></div>
			</article>

<?php endwhile; // end of the loop.?>
		</div>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>