<?php
/**
 * Order post via drag and drop on posttype admin screen
 *
 * See: http://sneekdigital.co.uk/2012/01/custom-post-types-with-a-drag-drop-interface/
 *
 **/


/**
 * Load the jQuery
 **/
function i3sl_order_post_script() {

	global $post_type;
	if( $post_type == 'i3_slide' ) { // Only load script on post type

		wp_enqueue_script( 'i3sl-admin-order', plugins_url('admin-posttype-order.js', __FILE__ ) );

	} // END if is posttype
}
add_action( 'admin_enqueue_scripts', 'i3sl_order_post_script' );


/**
 * Posttype update function
 **/
function i3sl_update_post_order() {
	global $wpdb;

	$post_type     = 'i3_slide';
	$order        = $_POST['order'];

	foreach( $order as $menu_order => $post_id ) {
		$post_id        = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	#die( '1' ); // wp_die?
	wp_die();
}
add_action( 'wp_ajax_i3sl_update_post_order', 'i3sl_update_post_order' );