<?php

# http://www.paulund.co.uk/add-button-tinymce-shortcodes
#http://www.wpexplorer.com/wordpress-tinymce-tweaks/ 

new Shortcode_Tinymce();
class Shortcode_Tinymce
{
    public function __construct()
    {
        // Only add_action if post-type is not slide
        global $post_type;
        if (empty($post_type) && !empty($_GET['post'])) {
            $post = get_post($_GET['post']);
            $post_type = $post->post_type;
        }

        if( $post_type !== 'i3_slide' ) {
            add_action('admin_init', array($this, 'i3sl_shortcode_button'));
        } // If is not cpt "slide"
    }

    /**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function i3sl_shortcode_button()
    {
        global $post_type;

        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
        {
            add_filter( 'mce_external_plugins', array($this, 'i3sl_add_buttons' ));
            add_filter( 'mce_buttons', array($this, 'i3sl_register_buttons' ));
        }
    }

    /**
     * Add new Javascript to the plugin script array
     *
     * @param  Array $plugin_array - Array of scripts
     *
     * @return Array
     */
    public function i3sl_add_buttons( $plugin_array )
    {
        $plugin_array['pushortcodes'] = plugin_dir_url( __FILE__ ) . 'admin-editor-button.js';
        return $plugin_array;
    }

    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     *
     * @return Array
     */
    public function i3sl_register_buttons( $buttons )
    {
        array_push( $buttons, 'separator', 'pushortcodes' );
        return $buttons;
    }
} // END new.Shortcode

/**
 * Style the admin editor button
 **/
function i3sl_admin_button_css() {

    global $post_type;
    // Only load if is not i3_slide posttype
    if( $post_type !== 'i3_slide' ) {

        echo '<style type="text/css">
        i.mce-i-icon {
            font: 400 20px/1 dashicons;
            padding: 0;
            vertical-align: top;
            speak: none;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin-left: -2px;
            padding-right: 2px
        }
        </style>';

    } // END if is posttype
}
add_action('admin_head', 'i3sl_admin_button_css'); ?>