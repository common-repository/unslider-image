<?php 
/*
Plugin Name: unslider-image
Plugin URI: http://pashabd.com/plugins/unslider-image-page/
Description: This plugin will enable a slider in your wordpress theme. You can embed a slider via shortcode in everywhere you want, even in theme files. 
Author: pashabd
Version: 1.0
Author URI: http://pashabd.com/
*/

function pashabd_unslider_plugin_js() {
    wp_enqueue_script( 'pashabd-unslider-js', plugins_url( '/js/unslider.js', __FILE__ ), array('jquery'), 1.0, true);
    wp_enqueue_script( 'pashabd-unslider-active-js', plugins_url( '/js/active.js', __FILE__ ), array('jquery'), 1.0, true);
   
	
	
	
}

add_action('init','pashabd_unslider_plugin_js');

// Register style sheet.
add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );

/**
 * Register style sheet.
 */
function register_plugin_styles() {
 wp_register_style( 'pashabd-unslider-css',plugins_url( '/css/unslider-css.css', __FILE__ ));
	//wp_register_style( 'my-plugin', plugins_url( 'my-plugin/css/plugin.css' ) );
	wp_enqueue_style( 'pashabd-unslider-css' );
}

function pashabd_unslider_image_active () {?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
						if(window.chrome) {
				$('.banner_unslider li').css('background-size', '100% 100%');
			}
			
			$('.banner_unslider').unslider({
				fluid: true,
				dots: true,
				speed: 500
			});
		
			//  Find any element starting with a # in the URL
			//  And listen to any click events it fires
			$('a[href^="#"]').click(function() {
				//  Find the target element
				var target = $($(this).attr('href'));
				
				//  And get its position
				var pos = target.offset(); // fallback to scrolling to top || {left: 0, top: 0};
				
				//  jQuery will return false if there's no element
				//  and your code will throw errors if it tries to do .offset().left;
				if(pos) {
					//  Scroll the page
					$('html, body').animate({
						scrollTop: pos.top,
						scrollLeft: pos.left
					}, 1000);
				}
				
				//  Don't let them visit the url, we'll scroll you there
				return false;
			});
			
		

		}); 	
	</script>
<?php
}
//add_action('wp_footer','pashabd_unslider_image_active');


function pashabd_unslider_image_slider_shortcode($atts){
	extract( shortcode_atts( array(
		'category' => '',
		'count' => '4',
		'category_slug' => 'category_ID',
	), $atts, 'projects' ) );
	$list='';
	//$list='<img width="34" height="27" alt="Unslider logo" src="' . plugins_url( 'img/logo.png' , __FILE__ ) . '" id="logo">';
	
	 $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => 'post', $category_slug => $category,'ignore_sticky_posts' => true)
        );		
		
		$pic=array('sunset.jpg','subway.jpg','wood.jpg','shop.jpg');
	    $i=0;
		
		$list.='<div class="banner_unslider has-dots" style="overflow: hidden; width: 100%; height: 350px!important;">
			<ul style="width: 100%; position: relative; left: -199.479%; height: 350px; overflow: hidden;">';
			while($q->have_posts()) : $q->the_post();
		$post_id = get_the_ID();
		
		$list.='<li style="background-image: url(' . plugins_url( 'img/'.$pic[$i++].'' , __FILE__ ) . '); width: 25%;">';
				//$list.='<li style="background-image: url(http://unslider.com/img/' . $pic[$i++]. '); width: 25%;">
		$list.='<h1>'.wp_trim_words(get_the_title(),  5 ).'</h1>
					<p>'.wp_trim_words( get_the_content(), 16 ).'</p>
					
					<a href="'. get_permalink($post_id).'" class="btn" target="_blank">Link</a>
				</li>';
				endwhile;
				$list.= '</ul></div>';
				wp_reset_query();

				
	return $list;
    }
add_shortcode('image_slider', 'pashabd_unslider_image_slider_shortcode');	



?>