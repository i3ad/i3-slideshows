<?php 
/**
 * Reorder the admin postlist to match menu_order
 *
 * See: http://www.dansmart.co.uk/2011/09/how-to-order-your-custom-post-type-edit-screen-by-menu-order/
 *
 **/
function i3sl_post_order($query) {
    if($query->is_admin) {
     
        if ($query->get('post_type') == 'i3_slide') {
            $query->set('orderby', 'menu_order');
            $query->set('order', 'ASC');
        }
    }
    return $query;
}
add_filter('pre_get_posts', 'i3sl_post_order');