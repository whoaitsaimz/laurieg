<?php
/**
 * Recent Press Widget Class
 */

// Creating the widget 
class Theme_Widget_Recent_Press extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_press', 'description' => __( "Custom widget by Color &amp; Code", 'striking_admin') );
		parent::__construct('recent_press', __('custom - Recent Press Widget', 'striking_admin'), $widget_ops);
		$this->alt_option_name = 'widget_recent_press';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('theme_widget_recent_press', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent TV Appearances', 'striking_front') : $instance['title'], $instance, $this->id_base);
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;
		
		if ( !$desc_length = (int) $instance['desc_length'] )
			$desc_length = 80;
		else if ( $desc_length < 1 )
			$desc_length = 1;
		
		$disable_thumbnail = $instance['disable_thumbnail'] ? '1' : '0';
		$display_extra_type = $instance['display_extra_type'] ? $instance['display_extra_type'] :'time';
		
		$query = array('post_type' => 'press', 'media' => 'news', 'showposts' => $number, 'nopaging' => 0, 'orderby'=> 'date', 'order'=>'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
		if(!empty($instance['cat'])){
			$query['cat'] = implode(',', $instance['cat']);
		}
		$r = new WP_Query($query);
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="posts_list">
<?php  while ($r->have_posts()) : $r->the_post(); ?>
<?php   $lightbox_title = get_field('lightbox_title');
        $lightbox_href = get_field('lightbox_href');
        $lightbox_width = get_field('lightbox_width');
        $lightbox_height = get_field('lightbox_height'); ?>
			<li class="press-item">
<?php if(!$disable_thumbnail):?>
				<a class="thumbnail" href="<?php echo $lightbox_href; ?>" title="<?php the_title();?>">
					
<?php if (has_post_thumbnail() ): ?>
					<?php the_post_thumbnail(array(150,150,true),array('title'=>get_the_title(),'alt'=>get_the_title())); ?>	
<?php else:?>
					<img src="<?php echo THEME_IMAGES."/press-noimage.png"; ?>" width="65" height="65" title="<?php the_title();?>" alt="<?php the_title();?>"/>
<?php endif;//end has_post_thumbnail ?>
				</a>
<?php endif;//disable_thumbnail ?>
				<div class="post_extra_info">
					<a href="<?php echo $lightbox_href; ?>" title="<?php the_title();?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
<?php if($display_extra_type == 'time'):?>
					<time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time>
<?php elseif($display_extra_type == 'description'):?>
					<p><?php echo wp_html_excerpt(get_the_excerpt(),$desc_length);?>...</p>
<?php endif;//end display extra type ?>
				</div>
				<div class="clearboth"></div>
			</li>
<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_query();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('theme_widget_recent_press', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['desc_length'] = (int) $new_instance['desc_length'];
		$instance['disable_thumbnail'] = !empty($new_instance['disable_thumbnail']) ? 1 : 0;
		$instance['display_extra_type'] = $new_instance['display_extra_type'];
		$instance['cat'] = $new_instance['cat'];

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['theme_widget_recent_press']) )
			delete_option('theme_widget_recent_press');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('theme_widget_recent_press', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __( 'Recent TV Appearances', 'wpb_widget_domain' );
		$disable_thumbnail = isset( $instance['disable_thumbnail'] ) ? (bool) $instance['disable_thumbnail'] : false;
		$display_extra_type = isset( $instance['display_extra_type'] ) ? $instance['display_extra_type'] : 'time';
		$cat = isset($instance['cat']) ? $instance['cat'] : array();

		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5;

		if ( !isset($instance['desc_length']) || !$desc_length = (int) $instance['desc_length'] )
			$desc_length = 80;

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'striking_admin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'striking_admin'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('disable_thumbnail'); ?>" name="<?php echo $this->get_field_name('disable_thumbnail'); ?>"<?php checked( $disable_thumbnail ); ?> />
		<label for="<?php echo $this->get_field_id('disable_thumbnail'); ?>"><?php _e( 'Disable Post Thumbnail?', 'striking_admin' ); ?></label></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('display_extra_type'); ?>"><?php _e( 'Display Extra infomation type:', 'striking_admin' ); ?></label>
			<select name="<?php echo $this->get_field_name('display_extra_type'); ?>" id="<?php echo $this->get_field_id('display_extra_type'); ?>" class="widefat">
				<option value="time"<?php selected($display_extra_type,'time');?>><?php _e( 'Time', 'striking_admin' ); ?></option>
				<option value="description"<?php selected($display_extra_type,'description');?>><?php _e( 'Description', 'striking_admin' ); ?></option>
				<option value="none"<?php selected($display_extra_type,'none');?>><?php _e( 'None', 'striking_admin' ); ?></option>
			</select>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('desc_length'); ?>"><?php _e('Length of Description to show:', 'striking_admin'); ?></label>
		<input id="<?php echo $this->get_field_id('desc_length'); ?>" name="<?php echo $this->get_field_name('desc_length'); ?>" type="text" value="<?php echo $desc_length; ?>" size="3" /></p>

<?php
	}
}