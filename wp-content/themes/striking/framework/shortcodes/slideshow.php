<?php

function theme_shortcode_slideshow($atts, $content = null){
	if(isset($atts['type'])){
		switch($atts['type']){
			case 'nivo':
				return theme_slideshow_nivo($atts, $content);
				break;
		}
	}
	return '';
}
add_shortcode('slideshow', 'theme_shortcode_slideshow');

function theme_slideshow_nivo($atts, $content = null){
	extract(shortcode_atts(array(
		'number' => 5,
		'width' => '630',
		'height' => '300',
		'category' => '',
		'effect' => 'random',
		'slices' => '10',
		'boxCols' => '8',
		'boxRows' => '4',
		'animspeed' => '500',
		'pausetime' => '3000',
		'controlnav' => 'false',
		'pauseonhover' => 'false',
		'caption' => 'false',
	), $atts));

	$id = rand(1,1000);
	//wp_print_scripts('jquery-nivo');
	
	if($controlnav==='true'){
		$controlnav = 'true';
	}else{
		$controlnav = 'false';
	}
	if($pauseonhover==='true'){
		$pauseonhover = 'true';
	}else{
		$pauseonhover = 'false';
	}

	if($category==''){
		$category='s|all';
	}else{
		$category='s|'.$category;
	}
	$size[0]=$width;
	$size[1]=$height;
		
	$content = trim($content);
	$images = !empty($content)?preg_split("/(\r?\n)/", $content):'';
		
	if(!empty($images) && is_array($images)){
		$content = '';
		foreach($images as $image){
			$image = trim(strip_tags($image));
			
			if(!empty($image)){
				$content .= '<img src="' . THEME_INCLUDES.'/timthumb.php?src='.strip_tags($image).'&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1' . '" title="" alt="" />';
			}
		}
	}else{
		$images = theme_generator('slideShow_getImages',$category,$number,$size);
		foreach($images as $image) {
			if($caption == 'true'){
				$content .= '<img src="' . THEME_INCLUDES.'/timthumb.php?src='.get_image_src($image['src']).'&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1' . '" title="'.$image['title'].'" alt="" />';
			}else{
				$content .= '<img src="' . THEME_INCLUDES.'/timthumb.php?src='.get_image_src($image['src']).'&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1' . '" title="" alt="" />';
			}
		}
	}

	return <<<HTML
[raw]
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#nivoslider_{$id}').nivoSlider({
        effect:'{$effect}',
        slices:{$slices}, 
        boxCols: {$boxCols},
        boxRows: {$boxRows},
        animSpeed:'{$animspeed}',
        pauseTime:'{$pausetime}',
        startSlide:0, 
        directionNav:false,
        directionNavHide:true, 
        controlNav:{$controlnav}, 
        controlNavThumbs:false, 
        keyboardNav:false,
        pauseOnHover:{$pauseonhover}, 
        manualAdvance:false, 
        captionOpacity:0.8
    });
});
</script>
<style type="text/css">
#nivoslider_{$id} {
	width: {$width}px;
	height: {$height}px;
}
</style>	
<div id="nivoslider_{$id}" class="nivoslider_wrap">
{$content}
</div>
[/raw]
HTML;

}