<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 */
$featured_image_type = theme_get_option('blog', 'featured_image_type');
$layout = theme_get_option('blog','layout');
$columns = theme_get_option('blog','columns');

$columns = (int)$columns;
if($columns > 6){
	$columns = 6;
}elseif($columns < 1){
	$columns = 1;
}
if ($columns != 1) {
	if($layout == 'full'){
		$layout = floor((958-25*($columns-1))/$columns);
	}else{
		$layout = floor((628-25*($columns-1))/$columns);
	}
}
$i = 0;
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
$i++;
$class = array('half','third','fourth','fifth','sixth');
$css = $class[$columns-1];
if ($columns != 1) {
	if ($i%$columns !== 0) {
		echo "<div class=\"one_{$css}\">";
	} else {
		echo "<div class=\"one_{$css} last\">";
	}
}
?>
<article id="post-<?php the_ID(); ?>" class="entry entry_<?php echo $featured_image_type;?>"> 
	<div class="entry_info">
		<h2 class="entry_title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php printf( __("Permanent Link to %s", 'striking_front'), get_the_title() ); ?>"><?php the_title(); ?></a></h2>
		<div class="entry_meta">
<?php echo theme_generator('blog_meta'); ?>
		</div>
		<div class="entry_content">
<?php 
	if(theme_get_option('blog','display_full')):
		global $more;
		$more = 0;
		the_content(__('Read more &raquo;','striking_front'),false);
	else:
		the_excerpt();
?>
		<a class="read_more_link" href="<?php the_permalink(); ?>"><?php echo __('Read more &raquo;','striking_front')?></a>
<?php endif; ?>
		</div>
	</div>
</article>
<?php

if ($columns != 1) {
	echo '</div>';
	if ($i%$columns === 0) {
		echo "<div class=\"clearboth\"></div>";
	}
}

endwhile;
wp_reset_postdata();
?>