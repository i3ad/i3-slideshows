<?php 
/**
 * Create taxonomy filter for slider posttype
 **/
function i3sl_taxonomy_filter() {
    global $typenow;
 
    // an array of all the taxonomies you want to display. Use the taxonomy name or slug
    $taxonomies = array('i3_slider_group');
 
    // must set this to the post type you want the filter(s) displayed on
    if( $typenow == 'i3_slide' ){
 
        foreach ($taxonomies as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            $terms = get_terms($tax_slug);
            if(count($terms) > 0) {
                echo "<select name='".$tax_slug."' id='".$tax_slug."' class='postform'>";
                echo "<option value=''>".__('Show All', 'i3sl-plugin')." ".$tax_name."</option>";
                foreach ($terms as $term) {

                	// Check if "$tax_slug" is empty/set
                	$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;

                    echo '<option value='. $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . __($term->name) .' (' . $term->count .')</option>'; 
                }
                echo "</select>";
            }
        }
    }
}
add_action( 'restrict_manage_posts', 'i3sl_taxonomy_filter' );