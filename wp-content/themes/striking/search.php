<?php 
$layout=theme_get_option('blog','layout');
get_header(); ?>
<?php theme_generator('introduce');?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
			<div class="content">
			<?php 
				$exclude_cats = theme_get_option('blog','exclude_categorys');
				foreach ($exclude_cats as $key => $value) {
					$exclude_cats[$key] = -$value;
				}
				$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$s = get_query_var('s');
				query_posts("s=$s&paged=$page&cat=".implode(",",$exclude_cats));
				
				get_template_part( 'content','search');
			?>
				<div class="clearboth"></div>
			</div>
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<?php get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>