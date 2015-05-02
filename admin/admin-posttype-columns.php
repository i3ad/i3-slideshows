<?php 
/**
 * Create posttype admin columns
 **/
function i3sl_admin_columns($columns) {
    return array(
        'menu_order'                => __('Order', 'i3sl-plugin'),
        'cb'                        => '<input type="checkbox" />',
        'title'                     => __('Title', 'i3sl-plugin'),
        'thumbnail'                 => __('Thumbnail', 'i3sl-plugin'),
        'taxonomy-i3_slider_group'  => __('Slide Group', 'i3sl-plugin'),
    );
}
add_filter('manage_edit-i3_slide_columns', 'i3sl_admin_columns');



/**
 * Fill new admin columns
 **/
function i3sl_admin_columns_content($columns, $post_id) {
    $the_post = get_post($post_id);

    switch ($columns) {

    	// Content for "menu_order" column
        case 'menu_order' :
            echo '<i class="fa fa-bars fa-3x"></i>';
            #echo '<br>'.$the_post->menu_order;

        break;

        // Content for "thumbnail" column
        case 'thumbnail' :
            echo '<a href="'.get_edit_post_link().'" title="'.__('Edit', 'i3sl-plugin').'">';
                if ( has_post_thumbnail() ) {
                    echo the_post_thumbnail( array(80,80) );
                }else{
                    echo __('No image', 'i3sl-plugin');
                }
            echo '</a>';
        break;

    } // END switch
}
add_action('manage_i3_slide_posts_custom_column', 'i3sl_admin_columns_content', 10, 2);


/**
 * Style the admin columns
 **/
function i3sl_admin_columns_css() {

    global $post_type;
    if( $post_type == 'i3_slide' ) {

        echo '<style type="text/css">
        .column-menu_order { width:40px !important; overflow:hidden; text-align:center !important; cursor:move }
        .column-thumbnail { width:90px !important; overflow:hidden; text-align:center !important }
        .column-taxonomy-i3_slider_group { width:15% !important; overflow:hidden }
        </style>';

    } // END if is posttype
}
add_action('admin_head', 'i3sl_admin_columns_css');