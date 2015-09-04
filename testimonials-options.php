<?php
/*
Plugin Name: CICR Testimonials Plugin
Plugin URI: http://camanoislandcoffee.com
Description: Your one stop spot for all of your manual testimonial needs.
Version: 1.0
Author: Tanner Legasse
Author URI:
License: GNU
*/

if (!defined('TO_URL'))
    define('TO_URL', plugins_url() . '/' . basename(dirname(__FILE__)) . '/');

if (!defined('TESTIMONIALS_FRONTEND'))
    define('TESTIMONIALS_FRONTEND', untrailingslashit(plugin_dir_path(__FILE__)));

if (!defined('TO_PATH'))
    define('TO_PATH', plugin_dir_path(__FILE__));
register_activation_hook(__FILE__, 'activationTables');

register_activation_hook(__FILE__, 'register_testimonials');

function register_tstimonials()
{
    echo "";
    
}


function my_custom_post_testimonial()
{
    $labels = array(
        'name' => _x('Testimonials', 'post type general name'),
        'singular_name' => _x('Testimonial', 'post type singular name'),
        'add_new' => _x('Add New', 'testimonial'),
        'add_new_item' => __('Add New Testimonial'),
        'edit_item' => __('Edit Testimonial'),
        'new_item' => __('New Testimonial'),
        'all_items' => __('All Testimonials'),
        'view_item' => __('View Testimonial'),
        'search_items' => __('Search Testimonials'),
        'not_found' => __('No Testimonials found'),
        'not_found_in_trash' => __('No Testimonials found in the Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Testimonials'
    );
    $args   = array(
        'labels' => $labels,
        'description' => 'Holds our testimonials and testimonial specific data',
        'public' => true,
        'menu_icon' => 'dashicons-format-quote',
        'menu_position' => 5,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'comments'
        ),
        'has_archive' => true
    );
    register_post_type('testimonial', $args);
}

add_action('init', 'my_custom_post_testimonial');

////////////////////////////////////////////////////
//		  The Coffee Review Widget shortcode      //
////////////////////////////////////////////////////

add_shortcode('coffee_review_content', 'review_callback');

function review_callback($atts, $content = '')
{
    $a       = shortcode_atts(array(
        'id' => '0',
        'color' => 'white',
        'time' => '11'
    ), $atts);
    $opacity = 1;
    $color   = isset($a['color']) ? $a['color'] : "blue";
    $id      = isset($a['id']) ? $a['id'] : "0";
    $time    = isset($a['time']) ? $a['time'] : "9";
    switch ($color) {
        case "blue":
            $background_color = "background: rgba(133, 170, 177, $opacity);";
            $color            = "color: #FFFFFF;";
            break;
        
        case "brown":
            $background_color = "background:rgba(80, 61, 32, $opacity);";
            $color            = "color: #FFFFFF;";
            break;
        
        case "purple":
            $background_color = "background:rgba(122, 81, 113, $opacity);";
            $color            = "color: #FFFFFF;";
            break;
        
        case "green":
            $background_color = "background:rgba(51, 63, 40, $opacity);";
            $color            = "color: #FFFFFF;";
            break;
        
        case "holiday-red":
            $background_color = "background:rgba(220, 26, 16, $opacity);";
            $color            = "color: #FFFFFF;";
            break;
        
        case "beige":
            $background_color = "background:rgba(234, 214, 190, $opacity);";
            $color            = "color: #503D20;";
            $loading_bar      = "rgba(234, 214, 190, $opacity);";
            break;
        
        case "grey":
            $background_color = "background:rgba(199, 203, 205, $opacity);";
            $color            = "color: #503D20;";
            break;
        
        case "white":
            $background_color = "background:rgba(255,255,255, 1);";
            $color            = "color: #503D20;";
            break;
        
        case "image":
            $background_color = "background:rgba(255,255,255, 1);";
            $color            = "color: rgba(255,255,255, 1);";
            break;
        
        default:
            $background_color = "rgba(255,255,255, 1);";
            $color            = "color: #503D20;";
            break;
    }
    
    $return_content = "
 <script>
 
	jQuery(document).ready(function($) {
	    	
	    reviewSlider();
	    
	    var timedInterval = window.setInterval(animateSlider, " . $time . "000);
	    
	    $('.textBubbleNumber-1').live('click', function() {
	        showhide(1);
	    });

	    $('.textBubbleNumber-2').live('click', function() {
	        showhide(2);
	    });

	    $('.textBubbleNumber-3').live('click', function() {
	        showhide(3);
	    });


	    $('.hidden-textBubbleNumber-1').live('click', function() {
	        showhide(1);
	    });

	    $('.hidden-textBubbleNumber-2').live('click', function() {
	        showhide(2);
	    });

	    $('.hidden-textBubbleNumber-3').live('click', function() {
	        showhide(3);
	    });
		
		
		function progress(\$element, flipflop) {
			if((flipflop % 2) == 1) {
	    		\$element.find('div').animate({ width: '0' }, 1);
	    		\$element.find('div').animate({ width: '100%' }, " . $time . "000); }
			if((flipflop % 2) == 0) {
	    		\$element.find('div').animate({ width: '28%' }, 1);
	    		\$element.find('div').animate({ width: '0%' }, " . $time . "000); }
		}
		
	    function showhide(id) {
	        if ($('.textBubbleNumber-' + id).is(':visible')) {
	            $('.textBubbleNumber-' + id).hide();
	            $('.hidden-textBubbleNumber-' + id).show('slow');
	            $('.hidden-textBubbleNumber-' + id).show('slow');
	            window.clearInterval(timedInterval)
	            timedInterval = null;
	        } else {
	            $('.textBubbleNumber-' + id).show();
	            $('.hidden-textBubbleNumber-' + id).hide();
	            $('.hidden-textBubbleNumber-' + id).hide();
	    		timedInterval = window.setInterval(animateSlider, " . $time . "000);
	        }
	    }
		
		function animateSlider() {
	    	$('#review-bubble-area').fadeOut('slow');
			setTimeout(reviewSlider, 500)
		}
		
		var flipflop = 1;
			
	    function reviewSlider() {
		$.when($.ajax({url: '/wp-content/plugins/cicr-testimonials/ajax/testimonials.php'})).done(function(result) {
            $('#review-bubble-area').html(result).fadeIn('slow');
			progress($('.progressBar'), flipflop);
				
            $('.line-clamp').each(function(index, element) {
                var original = element.textContent;
				var text = shorten(element.textContent, 190, element);
                element.textContent = text[1];
				if (text[0] == 1) {
					console.log(this);
					this.className = 'textBubbleNumber-' + (index + 1)
	            	$(this).hover(function() {
	            		$(this).css('cursor', 'pointer')});
					var hiddenDiv = 'hidden-' + this.id;
					var div = document.getElementById(hiddenDiv)
					$('.textBubbleNumber-' + (index + 1)).show();
	                $('<p class=\"bubble-text hidden-text hidden-textBubbleNumber-' + (index + 1) + '\">' + original + '</p>').hide().insertAfter(element);
				} else {
					this.id = '';
				}
			})
			flipflop++;
        	})
	    }

	    function shorten(text, maxLength, element) {
	        var ret = text;
			var clipped = 0;
	        if (ret.length > maxLength) {
	            ret = ret.substr(0, maxLength - 3) + ' ...';
				var clipped = 1;
	        } else {
	            var lines = 40 / maxLength;
	            if (lines > 0 < 1) {
	                $(this).height(1200);
	            }
	        }
	        return [clipped, ret];
	    }

	})
	</script>
	<style>
	@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,600,700);
	
.hidden-text {
	cursor: pointer;
}

.more-button {
	align-self: middle;
    margin-top: -5%;
    margin-bottom: 3%;
    margin-right: 5%;
    margin-left: 2%;
    border-style: solid;
    border-width: 3px;
    border-color: #523d26;
    background: transparent;
    padding: 1% 2%;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    -webkit-box-shadow: rgba(0,0,0,1) 0 0px 0;
    -moz-box-shadow: rgba(0,0,0,1) 0 0px 0;
    box-shadow: rgba(0,0,0,1) 0 0px 0;
    text-shadow: rgba(0,0,0,.4) 0 0px 0;
    font-size: 100%px;
    font-weight: bold;
    font-family: Ubuntu, Helvetica, Arial, Sans-Serif;
    text-decoration: none;
    vertical-align: middle;
    color: #503D20;
}

.progressBar {
    display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
    display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
    display: -ms-flexbox;      /* TWEENER - IE 10 */
    display: -webkit-flex;     /* NEW - Chrome */
    display: flex;  
	justify-content: center;
	-webkit-justify-content: center;
    min-width: 100%;
    height: 10px;
    background-color: #292929;
    align-self: flex-end !important;
	margin: 0 -15%;
}

.progressBar div {
    height: 100%;
    color: #fff;
    width: 0;
    max-width: 100%;
    $background_color
}

.bubble h3 {
		font-family: 'Open Sans', Arial, sans-serif;
		color: #42321C;
		margin-top: 30px;
		margin-bottom: 10px;
}

.bubble {
	padding-top: 10px;
    display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
    display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
    display: -ms-flexbox;      /* TWEENER - IE 10 */
    display: -webkit-flex;     /* NEW - Chrome */
	align-self: center;
	-webkit-align-self: center;
	justify-content: space-around;
	width: 300px;
	border-radius: 5px;
	background: #FFFFFF;
	margin-top: 50px;
	-webkit-flex-direction: column;
	flex-direction: column;
   -webkit-align-items: center;
   align-items: center;
   -webkit-justify-content: center;
   justify-content: center;
}

.bubble-image {
    display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
    display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
    display: -ms-flexbox;      /* TWEENER - IE 10 */
    display: -webkit-flex;     /* NEW - Chrome */
    display: flex;  
	width: 105px;
	height: 105px;
	border-radius: 75px;
	margin-top: -75px;
	border: 10px solid white;
	background-color: white;    
	-webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: cover !important; 
    background-repeat: no-repeat;
    background-position: 50% 50%;
}

.callout {
	position: relative;
    display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
    display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
    display: -ms-flexbox;      /* TWEENER - IE 10 */
    display: -webkit-flex;     /* NEW - Chrome */
    display: flex;  
	vertical-align: bottom;
	right: -30%;
	width: 0;
	height: 0;
	border-left: 25px solid transparent;
	border-top: 30px solid #FFFFFF;
	border-right: 0px solid transparent;
	margin-bottom: 20px;
}

.first-row {
	align-text: center;
	margin-top: 10px;
	widht: 100%;
	align-items: flex-start;
}


.star-row {
  display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
  display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
  display: -ms-flexbox;      /* TWEENER - IE 10 */
  display: -webkit-flex;     /* NEW - Chrome */
  display: flex;  
	-webkit-align-content: middle;
align-content: middle;
	margin: 25px auto
}

.review-content {
		margin: 0 10px 20px 10px;
		width: 270px;
		text-align: justify;
}

.star-five {
	flex-grow: 1;
		align-self: flex-start;
		margin-top: 30px;
		margin: 0 5px;
		width: 25px;
		height: 25px;
		background: #42321C;
		-webkit-clip-path: polygon(50% 0%, 63% 38%, 100% 38%, 69% 59%, 82% 100%, 50% 75%, 18% 100%, 31% 59%, 0% 38%, 37% 38%);
		clip-path: polygon(50% 0%, 63% 38%, 100% 38%, 69% 59%, 82% 100%, 50% 75%, 18% 100%, 31% 59%, 0% 38%, 37% 38%);
}

 .review-module {
      " . $background_color . "
      margin-left: -15%;
      margin-right:-15%;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      min-height: 750px;
      padding-top: 1;
      padding-bottom: 10%;
      position: static;
      padding-left: 15%;
      padding-right: 15%;
      max-width:100%;
      ' ." . $color . " . ';
      text-align: center;
  display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
  display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
  display: -ms-flexbox;      /* TWEENER - IE 10 */
  display: -webkit-flex;     /* NEW - Chrome */
  display: flex;  
      justify-content: space-between; 
      flex-wrap: wrap;
 }

 #review-bubble-area {
 	  display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
  display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
  display: -ms-flexbox;      /* TWEENER - IE 10 */
  display: -webkit-flex;     /* NEW - Chrome */
  display: flex;  
      justify-content: space-between; 
      flex-wrap: wrap;
      width:100%;
 }

 .review-module h1{
    " . $color . "
    font-size: 5.0em;
    line-height: 1.1em;
    font-weight: 700;
    

 }

 .review-module h2{
    " . $color . "
    font-size: 3em;
    line-height: 1.1em;
    font-weight: 700;
	padding-top: 25px;

    

 }
 
 
 .review-module h4{
    " . $color . "

 }
 
 .review-module h5{
    " . $color . "

 }
 
 .review-module h6{
    " . $color . "
    font-size: 1.2em;
    line-height: 1.1em;
    text-align: left;

 }
 
 .review-module ul{
    " . $color . "
 }
 
 .review-module li{
    " . $color . "
 }

</style>
<div style='clear:both;'></div>
<div class='review-module'>
	<h2 style='margin-top: 10px; align-self: flex-start'>WHAT OUR COFFEE LOVERS THINK OF THE BEST COFFEE FOR HOME</h2>
	<div id='review-bubble-area'></div>
	</div>
	<div class='progressBar'><div></div></div>";
    return $return_content;
}

?>