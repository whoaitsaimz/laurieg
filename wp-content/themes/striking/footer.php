<?php if(theme_get_option('footer','footer') || theme_get_option('footer','sub_footer')):
	wp_reset_query();
	if(is_front_page()){
		global $home_page_id;
		$footer_color = get_post_meta($home_page_id, '_footer_background_color', true);
	}else{
		$footer_color = get_post_meta(get_queried_object_id(), '_footer_background_color', true);
	}
	if(!empty($footer_color) && $footer_color != "transparent"){
		$footer_color = ' style="background-color:'.$footer_color.'"';
	}else{
		$footer_color = '';
	}
?>
<footer id="footer"<?php echo $footer_color;?>>
<?php if(theme_get_option('footer','footer')):?>
	<div class="inner">
<?php
$footer_column = theme_get_option('footer','column');
if(is_numeric($footer_column)):
	switch ( $footer_column ):
		case 1:
			$class = '';
			break;
		case 2:
			$class = 'one_half';
			break;
		case 3:
			$class = 'one_third';
			break;
		case 4:
			$class = 'one_fourth';
			break;
		case 5:
			$class = 'one_fifth';
			break;
		case 6:
			$class = 'one_sixth';
			break;
	endswitch;
	for( $i=1; $i<=$footer_column; $i++ ):
		if($i == $footer_column):
?>
			<div class="<?php echo $class; ?> last"><?php dynamic_sidebar('sidebar-5'); ?></div>
<?php else:?>
			<div class="<?php echo $class; ?>"><?php dynamic_sidebar('sidebar-5'); ?></div>
<?php endif;		
	endfor;
else:
	switch($footer_column):
		case 'third_sub_third':
?>
		<div class="one_third"><?php dynamic_sidebar('sidebar-5'); ?></div>
		<div class="two_third last">
			<div class="one_third"><?php dynamic_sidebar('sidebar-6'); ?></div>
			<div class="one_third"><?php dynamic_sidebar('sidebar-7'); ?></div>
			<div class="one_third last"><?php dynamic_sidebar('sidebar-8'); ?></div>
		</div>
<?php
			break;
		case 'sub_third_third':
?>
		<div class="two_third">
			<div class="one_third"><?php dynamic_sidebar('sidebar-5'); ?></div>
			<div class="one_third"><?php dynamic_sidebar('sidebar-6'); ?></div>
			<div class="one_third last"><?php dynamic_sidebar('sidebar-7'); ?></div>
		</div>
		<div class="one_third last"><?php dynamic_sidebar('sidebar-8'); ?></div>
<?php
			break;
		case 'third_sub_fourth':
?>
		<div class="one_third"><?php dynamic_sidebar('sidebar-5'); ?></div>
		<div class="two_third last">
			<div class="one_fourth"><?php dynamic_sidebar('sidebar-6'); ?></div>
			<div class="one_fourth"><?php dynamic_sidebar('sidebar-7'); ?></div>
			<div class="one_fourth"><?php dynamic_sidebar('sidebar-8'); ?></div>
			<div class="one_fourth last"><?php dynamic_sidebar('sidebar-9'); ?></div>
		</div>
<?php
			break;
		case 'sub_fourth_third':
?>
		<div class="two_third">
			<div class="one_fourth"><?php dynamic_sidebar('sidebar-5'); ?></div>
			<div class="one_fourth"><?php dynamic_sidebar('sidebar-6'); ?></div>
			<div class="one_fourth"><?php dynamic_sidebar('sidebar-7'); ?></div>
			<div class="one_fourth last"><?php dynamic_sidebar('sidebar-8'); ?></div>
		</div>
		<div class="one_third last"><?php dynamic_sidebar('sidebar-9'); ?></div>
<?php
			break;
		case 'half_sub_half':
?>
		<div class="one_half"><?php dynamic_sidebar('sidebar-5'); ?></div>
		<div class="one_half last">
			<div class="one_half"><?php dynamic_sidebar('sidebar-6'); ?></div>
			<div class="one_half last"><?php dynamic_sidebar('sidebar-7'); ?></div>
		</div>
<?php
			break;
		case 'half_sub_third':
?>
		<div class="one_half"><?php dynamic_sidebar('sidebar-5'); ?></div>
		<div class="one_half last">
			<div class="one_third"><?php dynamic_sidebar('sidebar-6'); ?></div>
			<div class="one_third"><?php dynamic_sidebar('sidebar-7'); ?></div>
			<div class="one_third last"><?php dynamic_sidebar('sidebar-8'); ?></div>
		</div>
<?php
			break;
		case 'sub_half_half':
?>
		<div class="one_half">
			<div class="one_half"><?php dynamic_sidebar('sidebar-5'); ?></div>
			<div class="one_half last"><?php dynamic_sidebar('sidebar-6'); ?></div>
		</div>
		<div class="one_half last"><?php dynamic_sidebar('sidebar-7'); ?></div>
<?php
			break;
		case 'sub_third_half':
?>
		<div class="one_half">
			<div class="one_third"><?php dynamic_sidebar('sidebar-5'); ?></div>
			<div class="one_third"><?php dynamic_sidebar('sidebar-6'); ?></div>
			<div class="one_third last"><?php dynamic_sidebar('sidebar-7'); ?></div>
		</div>
		<div class="one_half last"><?php dynamic_sidebar('sidebar-8'); ?></div>
<?php
			break;
	endswitch;
endif;
?>
		<div class="clearboth"></div>
	</div>
<?php endif;?>
<?php if(theme_get_option('footer','sub_footer')):?>
	<div id="footer_bottom">
		<div class="inner">
			<div id="copyright"><?php echo wpml_t(THEME_NAME, 'Copyright Footer Text',stripslashes(theme_get_option('footer','copyright')))?></div>
<?php 
	$footer_right_area_type = theme_get_option('footer','footer_right_area_type');
	switch($footer_right_area_type){
		case 'html':
			echo '<div id="footer_right_area">';
			echo do_shortcode(wpml_t(THEME_NAME, 'Footer Right Area Html Code',stripslashes( theme_get_option('footer','footer_right_area_html') )));
			echo '</div>';
			break;
		case 'menu':
			wp_nav_menu(array( 
				'theme_location' => 'footer-menu',
				'container' => 'nav',
				'container_id' => 'footer_menu',
				'fallback_cb' => ''
			));
			break;
		case 'widget':
			echo '<div id="footer_right_area">';
			dynamic_sidebar(__('Sub Footer Widget Area','striking_admin'));
			echo '</div>';
			break;
	}
?>
			<div class="clearboth"></div>
		</div>
	</div>
<?php endif;?>
</footer>
<?php endif;?>
<?php 
	// theme_add_cufon_code_footer();
	wp_footer();
	if(theme_get_option('general','analytics') && theme_get_option('general','analytics_position')=='bottom'){
		echo stripslashes(theme_get_option('general','analytics'));
	}
?>
</body>
</html>