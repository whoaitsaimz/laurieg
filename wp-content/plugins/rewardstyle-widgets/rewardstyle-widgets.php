<?php
/*
Plugin Name: rewardStyle Widget
Plugin URI: http://www.rewardstyle.com
Description: The rewardStyle plugin allows bloggers to use rewardStyle widgets on their WordPress blog
Author: rewardStyle
Author URI: http://www.rewardstyle.com
Version: 1.53
*/

require 'plugin-updates/plugin-update-checker.php';
$ExampleUpdateChecker = new PluginUpdateChecker_1_5(
    'http://www.rewardstyle.com/assets/info.json',
    __FILE__,
    'rewardstyle-widgets',
    1
);

/**
 * Add these to the KSES 'Allowed Post Tags' global
 * var. Keeps these tags from being removed in the
 * save/update process.
 */
$GLOBALS['allowedposttags']['iframe'] = array(
    'id'           => TRUE,
    'class'        => TRUE,
    'title'        => TRUE,
    'style'        => TRUE,
    'align'        => TRUE,
    'frameborder'  => TRUE,
    'height'       => TRUE,
    'longdesc'     => TRUE,
    'marginheight' => TRUE,
    'marginwidth'  => TRUE,
    'name'         => TRUE,
    'scrolling'    => TRUE,
    'src'          => TRUE,
    'width'        => TRUE
);
$GLOBALS['allowedposttags']['script'] = array(
    'id'    => TRUE,
    'class' => TRUE,
    'src'   => TRUE,
    'type'  => TRUE,
    'name'  => TRUE
);

/**
 * Add these to the Tiny MCE whitelist of acceptable Tags.
 * This keeps the values available when loading the page,
 * and when switching from Visual/Text Tabs
 */
function unfilter_iframe($initArray) {
  if (isset($initArray['extended_valid_elements'])) {
    $initArray['extended_valid_elements'] .= ",+iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
  }
  else {
    $initArray['extended_valid_elements'] = "+iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
  }
  return $initArray;
}
function unfilter_script($initArray) {
  if (isset($initArray['extended_valid_elements'])) {
    $initArray['extended_valid_elements'] .= ",+script[id|class|src|type|name]";
  }
  else {
    $initArray['extended_valid_elements'] = "+script[id|class|src|type|name]";
  }
  return $initArray;
}
add_filter('tiny_mce_before_init', 'unfilter_iframe');
add_filter('tiny_mce_before_init', 'unfilter_script');

// Add shortcode support to completely bypass the iframe filter
add_shortcode( 'show_rs_widget', 'rs_show_widget');
function rs_show_widget($atts, $content = null) {
    extract(shortcode_atts(array(
        'wid' => '',
        'blog' => '',
        'product_ids' => '',
        'rows' => '',
        'cols' => '',
        'brand' => '',
        'price' => '',
        'hover' => ''
    ), $atts));

$h = $rows * 120;
$w = ($cols * 110) + 50;

$magic_num = 0;
$how_tall = '120';
$prod_box = 'show';
if ($brand == 1) {
    $magic_num++;
}
if ($price == 1) {
    $magic_num++;
}
if ($hover == 1) {
    $magic_num = 0;
    $prod_box = 'hover-info';
}
if ($magic_num == 1) {
    $how_tall = '162';
} else if ($magic_num == 2) {
    $how_tall = '195';
}

$out = "<div style='width: ".$w."px; height: ".$how_tall."px; margin: 0px auto; background:white;'>
           <iframe frameborder='0' width='".$w."px' height='".$how_tall."px' scrolling='no' src='http://currentlyobsessed.me/api/v1/get_widget?wid=".$wid."&blog=".$blog."&product_ids=".$product_ids."&rows=".$rows."&cols=".$cols."&brand=".$brand."&price=".$price."&hover=".$hover."'></iframe>
        </div>";

return $out;
}

function ms_show_widget($atts) {
    extract(shortcode_atts(array(
        'id'       => '0',
        'image_id' => '0',
        'width'    => '0',
        'height'   => '0',
        'adblock'  => 'Disable your ad blocking software to view this content.',
        'enableJs' => 'JavaScript is currently disabled in this browser.  Reactivate it to view this content.'
    ), $atts));

    $out = '<div class="moneyspot-widget" data-widget-id="'.$id.'">
                <script type="text/javascript" language="javascript">
                    !function(d,s,id){
                        var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
                        if(!d.getElementById(id)) {
                            e     = d.createElement(s);
                            e.id  = id;
                            e.src = p + \'://widgets.rewardstyle.com/js/widget.js\';
                            d.body.appendChild(e);
                        }
                        if(typeof(window.__moneyspot) === \'object\') {
                            if(document.readyState === \'complete\') {
                                window.__moneyspot.init();
                            }
                        }
                    }(document, \'script\', \'moneyspot-script\');
                </script>
                <div class="rs-adblock">
                    <img src="//images.rewardstyle.com/img?v=2.11&ms='.$id.'&aspect" onerror="this.parentNode.innerHTML=\'Turn off your ad blocker to view content\'" />
                    <noscript>'.$enableJs.'</noscript>
                </div>
            </div>';

    return $out;
}
add_shortcode('show_ms_widget', 'ms_show_widget');

function ltk_show_widget($atts) {
    extract(shortcode_atts(array(
        'user_id'    => '0',
        'rows'       => '1',
        'cols'       => '6',
        'show_frame' => 'true',
        'padding'    => '0'
    ), $atts));

    $out = '<div class="ltkwidget-widget" data-rows="'.$rows.'" data-cols="'.$cols.'" data-show-frame="'.$show_frame.'" data-user-id="'.$user_id.'" data-padding="'.$padding.'">
                <script type="text/javascript" language="javascript">
                    !function(d,s,id){
                        var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
                        if(!d.getElementById(id)) {
                            e     = d.createElement(s);
                            e.id  = id;
                            e.src = p + \'://widgets.rewardstyle.com/js/ltkwidget.js\';
                            d.body.appendChild(e);
                        }
                    }(document, \'script\', \'ltkwidget-script\');
                    if(typeof(window.__ltkwidget) === \'object\'){
                        if (document.readyState === \'complete\') {
                            __ltkwidget.init();
                        }
                    }
                </script>
                <div class="rs-adblock">
                    <img src="//assets.rewardstyle.com/images/search/350.gif" onerror="this.parentNode.innerHTML=\''.$adblock.'\'" />
                    <noscript>'.$enableJs.'</noscript>
                </div>
            </div>';
    return $out;
}
add_shortcode('show_ltk_widget', 'ltk_show_widget');

function ltk_widget_version_two($atts) {
    extract(shortcode_atts(array(
        'app_id'     => '0',
        'user_id'    => '0',
        'rows'       => '1',
        'cols'       => '6',
        'show_frame' => 'true',
        'padding'    => '0'
    ), $atts));
    $out = '<div id="ltkwidget-version-two'.$app_id.'" data-appid="'.$app_id.'" class="ltkwidget-version-two">
                <script>var rsLTKLoadApp="0",rsLTKPassedAppID="'.$app_id.'";</script>
                <script type="text/javascript" src="//widgets-static.rewardstyle.com/widgets2_0/client/pub/ltkwidget/ltkwidget.js"></script>
                <div widget-dashboard-settings="" data-appid="'.$app_id.'" data-userid="'.$user_id.'" data-rows="'.$rows.'" data-cols="'.$cols.'" data-showframe="'.$show_frame.'" data-padding="'.$padding.'">
                    <div class="rs-ltkwidget-container">
                        <div ui-view=""></div>
                    </div>
                </div>
            </div>';
    return $out;
}
add_shortcode('show_ltk_widget_version_two', 'ltk_widget_version_two');

function lookbook_show_widget($atts) {
    extract(shortcode_atts(array(
        'id'    => '0',
        'adblock'  => 'Turn off your ad blocker to view content',
        'enableJs' => 'Turn on your JavaScript to view content'
    ), $atts));

    $out = '<div class="lookbook-widget" data-widget-id="'.$id.'">
                <script type="text/javascript" language="javascript">
                    !function(d,s,id){
                        var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
                        if(!d.getElementById(id)) {
                            e     = d.createElement(s);
                            e.id  = id;
                            e.src = p + \'://widgets.rewardstyle.com/js/lookbook.js\';
                            d.body.appendChild(e);
                        }
                        if(typeof(window.__lookbook) === \'object\') if(d.readyState === \'complete\') {
                            window.__lookbook.init();
                        }
                    }(document, \'script\', \'lookbook-script\');
                </script>
                <div class="rs-adblock">
                    <img src="//assets.rewardstyle.com/images/search/350.gif" style="width:15px;height:15px;" onerror="this.parentNode.innerHTML=\''.$adblock.'\'" />
                    <noscript>'.$enableJs.'</noscript>
                </div>
            </div>';
    return $out;
}
add_shortcode('show_lookbook_widget', 'lookbook_show_widget');

function shopthepost_show_widget($atts) {
    extract(shortcode_atts(array(
        'id'    => '0',
        'adblock'  => 'Turn off your ad blocker to view content',
        'enableJs' => 'Turn on your JavaScript to view content'
    ), $atts));

    $out = '<div class="shopthepost-widget" data-widget-id="'.$id.'">
                <script type="text/javascript" language="javascript">
                    !function(d,s,id){
                        var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
                        if(!d.getElementById(id)) {
                            e     = d.createElement(s);
                            e.id  = id;
                            e.src = p + \'://widgets.rewardstyle.com/js/shopthepost.js\';
                            d.body.appendChild(e);
                        }
                        if(typeof window.__stp === \'object\') if(d.readyState === \'complete\') {
                            window.__stp.init();
                        }
                    }(document, \'script\', \'shopthepost-script\');
                </script>
                <div class="rs-adblock">
                    <img src="//assets.rewardstyle.com/images/search/350.gif" style="width:15px;height:15px;" onerror="this.parentNode.innerHTML=\''.$adblock.'\'" />
                    <noscript>'.$enableJs.'</noscript>
                </div>
            </div>';
    return $out;
}
add_shortcode('show_shopthepost_widget', 'shopthepost_show_widget');

function boutique_show_widget($atts) {
    extract(shortcode_atts(array(
        'id'    => '0',
        'adblock'  => 'Turn off your ad blocker to view content',
        'enableJs' => 'Turn on your JavaScript to view content'
    ), $atts));

    $out = '<div class="boutique-widget" data-widget-id="'.$id.'">
                <script type="text/javascript" language="javascript">
                    !function(d,s,id){
                        var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
                        if(!d.getElementById(id)) {
                            e     = d.createElement(s);
                            e.id  = id;
                            e.src = p + \'://widgets.rewardstyle.com/js/boutique.js\';
                            d.body.appendChild(e);
                        }
                        if(typeof window.__boutique === \'object\') if(d.readyState === \'complete\') {
                            window.__boutique.init();
                        }
                    }(document, \'script\', \'boutique-script\');
                </script>
                <div class="rs-adblock">
                    <img src="//assets.rewardstyle.com/images/search/350.gif" style="width:15px;height:15px;" onerror="this.parentNode.innerHTML=\''.$adblock.'\'" />
                    <noscript>'.$enableJs.'</noscript>
                </div>
            </div>';
    return $out;
}
add_shortcode('show_boutique_widget', 'boutique_show_widget');

add_filter('widget_text', 'do_shortcode');
add_filter('the_excerpt', 'do_shortcode');

?>