<?php
/*
Plugin Name: i3 Slideshows
Plugin URI: 
Description: 
Author: Mo
Version: 1.0
Author URI: 
Text Domain: i3sl-plugin
Domain Path: /lang
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Init function
 **/
function i3sl_init_method() {

	// Load plugins textdomain
    #load_plugin_textdomain('i3sl-plugin', false, basename( dirname( __FILE__ ) ) . '/lang' );

    // Add thumbnail support to slide posttype
    add_theme_support( 'post-thumbnails', array( 'i3_slide' ) );

    // Enable custom imagesizes
    #add_image_size( 'i3ss-size', 420, 180, true ); // 220 pixels wide by 180 pixels tall, hard crop mode
}
add_action('init', 'i3sl_init_method');


/**
 * Enqueue the frontend stylesheet and scripts
 **/
function i3sl_frontend_enqueue() {
    if ( ! is_admin() ) { // Dont load these scripts in the admin backend
        
        // Enqueue FlexSlider
        wp_enqueue_style( 'i3sl-flex-css', plugins_url('/assets/flexslider/flexslider.css', __FILE__) );
        wp_enqueue_script( 'i3sl-flex-js', plugins_url('/assets/flexslider/jquery.flexslider-min.js', __FILE__), array('jquery'));

        // Plugin general styles
        wp_enqueue_style( 'i3sl-styles', plugins_url('/css/style.css', __FILE__) );
    }    
}
add_action('wp_enqueue_scripts', 'i3sl_frontend_enqueue');


/**
 * Enqueue the backend stylesheet and scripts
 **/
function i3sl_backend_enqueue() {

    global $post_type;
    if( $post_type == 'i3_slide' ) { // Only load script on post type

        // Enqueue FontAwesome
        wp_enqueue_style( 'i3sl-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0' );

        // Enqueue build in jQuery-Sortable script for admin order
        wp_enqueue_script( 'jquery-ui-sortable' );

    } // END if
} 
add_action( 'admin_enqueue_scripts', 'i3sl_backend_enqueue' );


/**
 * Register slide posttype
 **/

if ( ! function_exists('i3sl_post_type') ) {

// Register Custom Post Type
function i3sl_post_type() {

    $labels = array(
        'name'                => _x( 'Slides', 'Post Type General Name', 'i3sl-plugin' ),
        'singular_name'       => _x( 'Slide', 'Post Type Singular Name', 'i3sl-plugin' ),
        'menu_name'           => __( 'Slideshows', 'i3sl-plugin' ),
        'parent_item_colon'   => __( 'Parent Slide:', 'i3sl-plugin' ),
        'all_items'           => __( 'All Slides', 'i3sl-plugin' ),
        'view_item'           => __( 'View Slide', 'i3sl-plugin' ),
        'add_new_item'        => __( 'Add New Slide', 'i3sl-plugin' ),
        'add_new'             => __( 'New Slide', 'i3sl-plugin' ),
        'edit_item'           => __( 'Edit Slide', 'i3sl-plugin' ),
        'update_item'         => __( 'Update Slide', 'i3sl-plugin' ),
        'search_items'        => __( 'Search Slides', 'i3sl-plugin' ),
        'not_found'           => __( 'No slides found', 'i3sl-plugin' ),
        'not_found_in_trash'  => __( 'No slides found in Trash', 'i3sl-plugin' ),
    );
    $args = array(
        'label'               => __( 'i3_slide', 'i3sl-plugin' ),
        'description'         => __( 'Single slideshow items', 'i3sl-plugin' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'taxonomies'          => array( 'i3_slider_group' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-images-alt',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'i3_slide', $args );

}

// Hook into the 'init' action
add_action( 'init', 'i3sl_post_type', 0 );

}


/**
 * Register slider taxonomy
 **/

if ( ! function_exists( 'i3sl_taxonomy' ) ) {

// Register Custom Taxonomy
function i3sl_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Slide Groups', 'Taxonomy General Name', 'i3sl-plugin' ),
        'singular_name'              => _x( 'Slide Group', 'Taxonomy Singular Name', 'i3sl-plugin' ),
        'menu_name'                  => __( 'Slide Groups', 'i3sl-plugin' ),
        'all_items'                  => __( 'All Groups', 'i3sl-plugin' ),
        'parent_item'                => __( 'Parent Group', 'i3sl-plugin' ),
        'parent_item_colon'          => __( 'Parent Group:', 'i3sl-plugin' ),
        'new_item_name'              => __( 'New Group Name', 'i3sl-plugin' ),
        'add_new_item'               => __( 'Add New Group', 'i3sl-plugin' ),
        'edit_item'                  => __( 'Edit Group', 'i3sl-plugin' ),
        'update_item'                => __( 'Update Group', 'i3sl-plugin' ),
        'separate_items_with_commas' => __( 'Separate groups with commas', 'i3sl-plugin' ),
        'search_items'               => __( 'Search Groups', 'i3sl-plugin' ),
        'add_or_remove_items'        => __( 'Add or remove groups', 'i3sl-plugin' ),
        'choose_from_most_used'      => __( 'Choose from the most used groups', 'i3sl-plugin' ),
        'not_found'                  => __( 'Not Found', 'i3sl-plugin' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
    );
    register_taxonomy( 'i3_slider_group', array( 'i3_slide' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'i3sl_taxonomy', 0 );

}

/**
 * Include admin posttype metabox
 **/
include_once( dirname( __FILE__ ) . '/admin/admin-posttype-metabox/admin-posttype-metabox.php' );

/**
 * Include taxonomy-filter for posttype admin screen
 **/
include_once( dirname( __FILE__ ) . '/admin/admin-posttype-filter.php' );

/**
 * Include admin columns
 **/
include_once( dirname( __FILE__ ) . '/admin/admin-posttype-columns.php' );

/**
 * Include admin posttype reorder
 **/
include_once( dirname( __FILE__ ) . '/admin/admin-posttype-reorder.php' );

/**
 * Include admin posttype order (order via drag and drop)
 **/
include_once( dirname( __FILE__ ) . '/admin/admin-posttype-order/admin-posttype-order.php' );

/**
 * Include admin editor button for shortcode
 **/
include_once( dirname( __FILE__ ) . '/admin/admin-editor-button/admin-editor-button.php' );




/**
 * Frontpage template function
 **/
function i3sl_template($atts) {

	/* Get all shortcode variables */
	$atts = shortcode_atts(array(

        // Template attributes
    	"id"            	=> "", // Set a unique slider ID
        "type"              => "i3_slide", // Post type of slides
        "category"          => "", // Slug of slide group or category to display
        "exclude"           => "", // ID´s of post to exclude
        "height"            => "", // Slider height

        // jQuery attributes
    	"autostart"			=> "true", // Animate slider automatically (true/false)
    	"animation"			=> "fade", // Select your animation type, "fade" or "slide"
    	"speed"				=> "7000", // Set the speed of the slideshow cycling, in milliseconds
    	"animationspeed"	=> "600", // Set the speed of animations, in milliseconds
    	"loop"				=> "true", // Should the animation loop? If false, directionNav will received "disable" classes at either end
    	"direction"			=> "horizontal", // Set slide direction (horizontal/vertical)
    	"randomize"			=> "false", // Randomize slide order (true/false)
    	"navigation"		=> "true", // Display next/previous navigation (true/false)
    	"pagination"		=> "true", // Display pagination (true/false)
    	"controls"			=> "false", // Display start/pause controls
    	"keyboard"			=> "true", // Enable keyboard control
    	"autoheight"		=> "false", // Allow height of the slider to animate smoothly in horizontal mode (true/false)
    	"pauseonhover"		=> "false", // Pause the slideshow when hovering over slider (true/false)
    	"pauseonaction"		=> "true", // Pause the slideshow when interacting with control elements (true/false)
    	"touch"				=> "true", // Allow touch swipe navigation (true/false)
        "startat"           => "0", // The slide that the slider should start on (0 = first slide)
        "usecss"            => "true", // Use CSS 3 transitions by default
        "video"             => "false", // Disable CSS 3 if is video-slider
       
    ), $atts );
    extract( $atts );

	?>

	<!-- START of slider script -->
	<script type="text/javascript">
		jQuery(window).load(function() {

			<?php // If no ID is entered fallback and just display the .flexslider class
			if (!empty ($id)) { $uniqueID = '#'.$id; } else { $uniqueID = '.flexslider'; } ?>

    		jQuery('<?php echo $uniqueID; ?>').flexslider({

    			/* General settings */
	    			<?php if (isset($autostart)) { echo 'slideshow: '.$autostart.','; } ?>
	    			<?php if (isset($speed)) { echo 'slideshowSpeed: '.$speed.','; } ?>
	    			<?php if (isset($animation)) { echo 'animation: "'.$animation.'",'; } ?>
	        		<?php if (isset($loop)) { echo 'animationLoop: '.$loop.','; } ?>
                    <?php if (isset($animationspeed)) { echo 'animationSpeed: '.$animationspeed.','; } ?>
	        		<?php if (isset($direction)) { echo 'direction: "'.$direction.'",'; } ?>
		        	<?php if (isset($autoheight)) { echo 'smoothHeight: '.$autoheight.','; } ?>
					<?php if (isset($randomize)) { echo 'randomize: '.$randomize.','; } ?>
                    <?php if (isset($startat)) { echo 'startAt: '.$startat.','; } ?>

				/* Usability features */

					// Pause the slideshow when interacting with control elements, highly recommended.
					<?php if (isset($pauseonaction)) { echo 'pauseOnAction: '.$pauseonaction.','; } ?>

					// Pause the slideshow when hovering over slider, then resume when no longer hovering
					<?php if (isset($pauseonhover)) { echo 'pauseOnHover: '.$pauseonhover.','; } ?>

					// Allow touch swipe navigation of the slider on touch-enabled devices
					<?php if (isset($touch)) { echo 'touch: '.$touch.','; } ?>

					// Slider will use CSS3 transitions if available
                    <?php if (isset($usecss)) { echo 'useCSS: '.$usecss.','; } ?>

					// If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches
                    <?php if (isset($video)) { echo 'video: '.$video.','; } ?>

				/* Primary Controls */

					// Create navigation for paging control of each slide? Note: Leave true for manualControls usage
					<?php if (isset($pagination)) { echo 'controlNav: '.$pagination.','; } ?>

					// Create navigation for previous/next navigation? (true/false)
					<?php if (isset($navigation)) { echo 'directionNav: '.$navigation.','; } ?>

				/* Secondary Navigation */

					// Allow slider navigating via keyboard left/right keys
					<?php if (isset($keyboard)) { echo 'keyboard: '.$keyboard.','; } ?>
				
					// Create pause/play dynamic element
					<?php if (isset($controls)) { echo 'pausePlay: '.$controls.','; } ?>

				/* Carousel Options */
					itemWidth: 0, // Box-model width of individual carousel items, including horizontal borders and padding.
					itemMargin: 0, // Margin between carousel items.
					minItems: 0, // Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
					maxItems: 0, // Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
					move: 0, // Number of carousel items that should move on animation. If 0, slider will move all visible items.
	    	});
  		});
	</script><!-- END of slider script -->


	<!-- START of slider HTML -->
	<div <?php if (isset($id)) { echo 'id="'.$id.'"'; } ?> class="flexslider i3-slideshow">

        <?php
        global $post;

        // Assign the taxonomy argument, based on posttype
        if ($type == 'post') { // If posttype is "post" display arg "'category_name' => $category"
            $taxonomy = 'category_name';
        } elseif ($type == 'i3_slide') { // If posttype is "i3_slide" display arg "'i3_slider_group' => $category"
            $taxonomy = 'i3_slider_group';
        }

        // Set query arguments
        $args = array(
            'post_type'         => $type,
            $taxonomy           => $category,
            'posts_per_page'    => -1, // Display all posts
            'orderby'           => 'menu_order',
            'order'             => 'ASC',
            'exclude'           => $exclude,
            'post_status'       => 'publish',
            'suppress_filters'  => true 
        );

        $myposts = get_posts( $args ); ?>

		<ul class="slides">

            <?php foreach ( $myposts as $post ) : 
            setup_postdata( $post ); ?>

    			<li <?php post_class(); ?>>

                    <?php // If posttype is "i3_slide", use this template
                    if ($type == 'i3_slide') { 

                        /* Get all meta variables */
                        // Post ID
                        $slide_ID = get_the_ID();
                        // Slide URL
                        $slide_url = get_post_meta( $post->ID, 'meta-text', true );
                        // Slide URL target
                        $slide_target = get_post_meta( $post->ID, 'meta-select', true );
                        // Slide content layout
                        $slide_layout = get_post_meta( $post->ID, 'meta-radio2', true );
                        // Slide font color
                        $slide_color = get_post_meta( $post->ID, 'meta-color', true );
                        // Slide link color
                        $slide_refcolor = get_post_meta( $post->ID, 'meta-color3', true );
                        // Slide link color
                        $slide_hovcolor = get_post_meta( $post->ID, 'meta-color4', true );
                        // Slide background color
                        $slide_bgcolor = get_post_meta( $post->ID, 'meta-color2', true );
                        ?>

                        <style type="text/css">
                            .i3-slideshow .post-<?php echo $slide_ID; ?> .slide-caption {
                                background: <?php echo $slide_bgcolor; ?>;
                                color: <?php echo $slide_color; ?>;
                            }
                            .i3-slideshow .post-<?php echo $slide_ID; ?> .slide-caption a { color: <?php echo $slide_refcolor; ?>; }
                            .i3-slideshow .post-<?php echo $slide_ID; ?> .slide-caption a:hover { color: <?php echo $slide_hovcolor; ?>; }
                        </style>

                        <?php if ( $slide_layout !== 'content-none' && $post->post_content !== '' ){ // If layout is "content-none", dont display the caption ?>
                            <div class="slide-caption <?php echo $slide_layout; ?>">
                                <?php the_content(); ?>
                            </div>   
                        <?php }; // END is not "content-none" ?>

                        <?php // If a URL is enterd, wrap link around image
                        if( !empty( $slide_url ) ) { ?>
                            <a href="<?php echo esc_url( $slide_url ); ?>" target="<?php echo $slide_target; ?>" class="slideurl" title="<?php the_title_attribute(); ?>">
                                <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full' ); } ?>
                            </a>
                        <?php } else { // If no URL is entered, just display the image ?>
                            <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full' ); } ?>
                        <?php }; ?>

                    <?php // If posttype is anything else, use this template instead
                    } else { ?>

                        <div class="slide-caption">
                            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="slideurl" title="<?php the_title_attribute(); ?>">
                            <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full' ); } ?>
                        </a>

                    <?php }; // END is posttype ?>

    			</li>

            <?php endforeach;
            wp_reset_postdata(); ?>

		</ul><!-- END ul.slides -->

	</div><!-- END of slider HTML -->
 
<?php };// End of function



/**
 * Create shortcode to use in single products
 *
 * Use: [i3_slideshow]
 *
 **/
function i3sl_shortcode($atts, $content = null){

	ob_start();
		$content = i3sl_template($atts);
		$content = ob_get_contents();
	ob_end_clean();
	 
	return $content;
 
}
add_shortcode('i3-slideshow', 'i3sl_shortcode');


/**
 * Create template-tag to use in theme-files
 *
 * Use: <?php i3_slideshow(); ?>
 **/
function i3_slideshow(){
    print i3sl_template();
};