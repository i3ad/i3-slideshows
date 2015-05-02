<?php

/**
 * Adds a meta box to the post editing screen
 */
function i3sl_custom_meta() {
	add_meta_box( 
		'i3sl_meta', // HTML 'id' attribute of the edit screen section
		__( 'Slide Settings', 'i3sl-plugin' ), // Title of the edit screen section
		'i3sl_meta_callback', // Function that prints out the HTML for the edit screen section
		'i3_slide', // The type of writing screen on which to show the edit screen section
		'normal', // The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side')
		'high' // The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
	);
}
add_action( 'add_meta_boxes', 'i3sl_custom_meta' );


/**
 * Outputs the content of the meta box
 */
function i3sl_meta_callback( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'i3sl_nonce' );
	$i3sl_stored_meta = get_post_meta( $post->ID );
	?>

	<!-- Slide URL -->
	<p>
		<span class="i3sl-row-title">
			<label for="meta-text" class="i3sl-row-title"><?php _e( 'Link URL', 'i3sl-plugin' )?></label>
		</span>
		<div class="i3sl-row-content" style="width:70%">
			<input style="width:100%" type="text" name="meta-text" id="meta-text" placeholder="http://www.example.com" value="<?php if ( isset ( $i3sl_stored_meta['meta-text'] ) ) echo $i3sl_stored_meta['meta-text'][0]; ?>" />
			<p class="i3sl-row-desc"><?php _e('Enter the URL the slide should link to.', 'i3sl-plugin'); ?></p>
		</div>
	</p>

	<!-- Slide URL target -->
	<?php // Add default value
	if ( empty ( $i3sl_stored_meta['meta-select'] ) ) { $i3sl_stored_meta['meta-select'][0] = '_blank'; }; ?>
	<p>
		<span class="i3sl-row-title">
			<label for="meta-select" class="i3sl-row-title"><?php _e( 'Open Link-URL in ', 'i3sl-plugin' )?></label>
		</span>
		<div class="i3sl-row-content">
			<select name="meta-select" id="meta-select">
				<option value="_blank" <?php if ( isset ( $i3sl_stored_meta['meta-select'] ) ) selected( $i3sl_stored_meta['meta-select'][0], '_blank' ); ?>><?php _e( 'New Tab/Window', 'i3sl-plugin' )?></option>
				<option value="_self" <?php if ( isset ( $i3sl_stored_meta['meta-select'] ) ) selected( $i3sl_stored_meta['meta-select'][0], '_self' ); ?>><?php _e( 'Same Tab/Window', 'i3sl-plugin' )?></option>
			</select>
			<p class="i3sl-row-desc"><?php _e('Set the URL target.', 'i3sl-plugin'); ?></p>
		</div>
	</p>

	<hr>

	<!-- Content layout -->
	<?php // Add default value
	if ( empty ( $i3sl_stored_meta['meta-radio2'] ) ) { $i3sl_stored_meta['meta-radio2'][0] = 'content-left'; }; ?>
	<p>
		<span class="i3sl-row-title">
			<?php _e( 'Content Layout', 'i3sl-plugin' )?>
		</span>
		<div class="i3sl-row-content">

			<div class="i3sl-radio-group">

				<label for="meta-radio2-one" class="meta-radio-img">
					<input type="radio" name="meta-radio2" id="meta-radio2-one" value="content-left" <?php if ( isset ( $i3sl_stored_meta['meta-radio2'] ) ) checked( $i3sl_stored_meta['meta-radio2'][0], 'content-left' ); ?>>
					<img src="<?php echo plugins_url( 'admin-posttype-metabox/img/content_left.png', dirname(__FILE__) ) ?>"><br>
					<?php _e( 'Left', 'i3sl-plugin' )?>
				</label>

			</div>
			<div class="i3sl-radio-group">

				<label for="meta-radio2-two" class="meta-radio-img">
					<input type="radio" name="meta-radio2" id="meta-radio2-two" value="content-center" <?php if ( isset ( $i3sl_stored_meta['meta-radio2'] ) ) checked( $i3sl_stored_meta['meta-radio2'][0], 'content-center' ); ?>>
					<img src="<?php echo plugins_url( 'admin-posttype-metabox/img/content_center.png', dirname(__FILE__) ) ?>"><br>
					<?php _e( 'Center', 'i3sl-plugin' )?>
				</label>

			</div>
			<div class="i3sl-radio-group">

				<label for="meta-radio2-three" class="meta-radio-img">
					<input type="radio" name="meta-radio2" id="meta-radio2-three" value="content-right" <?php if ( isset ( $i3sl_stored_meta['meta-radio2'] ) ) checked( $i3sl_stored_meta['meta-radio2'][0], 'content-right' ); ?>>
					<img src="<?php echo plugins_url( 'admin-posttype-metabox/img/content_right.png', dirname(__FILE__) ) ?>"><br>
					<?php _e( 'Right', 'i3sl-plugin' )?>
				</label>

			</div>
			<div class="i3sl-radio-group">

				<label for="meta-radio2-four" class="meta-radio-img">
					<input type="radio" name="meta-radio2" id="meta-radio2-four" value="content-none" <?php if ( isset ( $i3sl_stored_meta['meta-radio2'] ) ) checked( $i3sl_stored_meta['meta-radio2'][0], 'content-none' ); ?>>
					<img src="<?php echo plugins_url( 'admin-posttype-metabox/img/content_none.png', dirname(__FILE__) ) ?>"><br>
					<?php _e( 'None', 'i3sl-plugin' )?>
				</label>

			</div>

			<p class="i3sl-row-desc"><?php _e('Select a specific content layout for this slide.', 'i3sl-plugin'); ?></p>

		</div>
	</p>

	<!-- Content font color -->
	<p>
		<span class="i3sl-row-title">
			<label for="meta-color" class="i3sl-row-title"><?php _e( 'Content Font Color', 'i3sl-plugin' )?></label>
		</span>
		<div class="i3sl-row-content">
			<input data-default-color="" name="meta-color" type="text" value="<?php if ( !empty ( $i3sl_stored_meta['meta-color'] ) ) { echo $i3sl_stored_meta['meta-color'][0]; }else{ echo '#ffffff'; } ?>" class="meta-color" />
			<p class="i3sl-row-desc"><?php _e('Select the font color of the slide.', 'i3sl-plugin'); ?></p>
		</div>
	</p>

	<!-- Content link color -->
	<p>
		<span class="i3sl-row-title">
			<label for="meta-color3" class="i3sl-row-title"><?php _e( 'Content Link Color', 'i3sl-plugin' )?></label>
		</span>
		<div class="i3sl-row-content">
			<input data-default-color="" name="meta-color3" type="text" value="<?php if ( !empty ( $i3sl_stored_meta['meta-color3'] ) ) { echo $i3sl_stored_meta['meta-color3'][0]; }else{ echo '#ffffff'; } ?>" class="meta-color" />
			<p class="i3sl-row-desc"><?php _e('Select the link color.', 'i3sl-plugin'); ?></p>
		</div>
	</p>

	<!-- Content link hover color -->
	<p>
		<span class="i3sl-row-title">
			<label for="meta-color4" class="i3sl-row-title"><?php _e( 'Content Link Hover Color', 'i3sl-plugin' )?></label>
		</span>
		<div class="i3sl-row-content">
			<input data-default-color="" name="meta-color4" type="text" value="<?php if ( !empty ( $i3sl_stored_meta['meta-color4'] ) ) { echo $i3sl_stored_meta['meta-color4'][0]; }else{ echo '#ffffff'; } ?>" class="meta-color" />
			<p class="i3sl-row-desc"><?php _e('Select the hover color.', 'i3sl-plugin'); ?></p>
		</div>
	</p>


	<!-- Content background color -->
	<p>
		<span class="i3sl-row-title">
			<label for="meta-color2" class="i3sl-row-title"><?php _e( 'Content Background Color', 'i3sl-plugin' )?></label>
		</span>
		<div class="i3sl-row-content">
			<input name="meta-color2" type="text" value="<?php if ( !empty ( $i3sl_stored_meta['meta-color2'] ) ) { echo $i3sl_stored_meta['meta-color2'][0]; }else{ echo '#000000'; } ?>" class="meta-color2" />
			<p class="i3sl-row-desc"><?php _e('Select the background color of the slide.', 'i3sl-plugin'); ?></p>
		</div>
	</p>

	<?php
}



/**
 * Saves the custom meta input
 */
function i3sl_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'i3sl_nonce' ] ) && wp_verify_nonce( $_POST[ 'i3sl_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
 
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'meta-text' ] ) ) {
		update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
	}


	// Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox' ] ) ) {
		update_post_meta( $post_id, 'meta-checkbox', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-checkbox', '' );
	}


	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-radio2' ] ) ) {
		update_post_meta( $post_id, 'meta-radio2', $_POST[ 'meta-radio2' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-select' ] ) ) {
		update_post_meta( $post_id, 'meta-select', $_POST[ 'meta-select' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-select2' ] ) ) {
		update_post_meta( $post_id, 'meta-select2', $_POST[ 'meta-select2' ] );
	}


	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-color' ] ) ) {
		update_post_meta( $post_id, 'meta-color', $_POST[ 'meta-color' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-color2' ] ) ) {
		update_post_meta( $post_id, 'meta-color2', $_POST[ 'meta-color2' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-color4' ] ) ) {
		update_post_meta( $post_id, 'meta-color4', $_POST[ 'meta-color4' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-color3' ] ) ) {
		update_post_meta( $post_id, 'meta-color3', $_POST[ 'meta-color3' ] );
	}

}
add_action( 'save_post', 'i3sl_meta_save' );


/**
 * Adds the meta box stylesheet when appropriate
 */
function i3sl_admin_styles(){
	global $typenow;
	if( $typenow == 'i3_slide' ) {

		wp_enqueue_style( 'i3sl_meta_box_styles', plugin_dir_url( __FILE__ ) . 'admin-posttype-metabox.css' );

	} // END if
}
add_action( 'admin_print_styles', 'i3sl_admin_styles' );


/**
 * Loads the color picker javascript
 */
function i3sl_color_enqueue() {
	global $typenow;
	if( $typenow == 'i3_slide' ) {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'meta-box-color-js', plugin_dir_url( __FILE__ ) . 'admin-posttype-metabox.js', array( 'wp-color-picker' ) );
	
	} // END if
}
add_action( 'admin_enqueue_scripts', 'i3sl_color_enqueue' );
