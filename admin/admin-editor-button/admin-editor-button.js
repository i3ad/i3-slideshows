(function() {
    tinymce.PluginManager.add('pushortcodes', function( editor ) {

        editor.addButton('pushortcodes', {
            icon: 'icon dashicons-images-alt',
            title: 'Insert a Slideshow',
            text: 'Slideshow',

            onclick: function() {
                editor.windowManager.open( {
                title: 'Insert Slideshow',
                    body: [
                        // Slider ID
                        {
                            type: 'textbox',
                            name: 'slider_id',
                            label: 'Unique slider ID',
                            value: '',
                            tooltip: 'Set a unique slider ID'
                        },
                        // Slider posttype
                        {
                            type: 'listbox',
                            name: 'slider_type',
                            label: 'Content type',
                            'values': [
                                {text: 'Slides', value: 'i3_slide'},
                                {text: 'Posts', value: 'post'}
                            ]
                        },
                        // Slider taxonomy
                        {
                            type: 'textbox',
                            name: 'slider_cat',
                            label: 'Category / Slide-group',
                            value: '',
                            tooltip: 'Slug of category or slide-group'
                        },
                        // Exclude posts
                        {
                            type: 'textbox',
                            name: 'slider_exclude',
                            label: 'Exclude',
                            value: '',
                            tooltip: 'Comma separated list of post ID´s to exclude'
                        },
                        // Slider animation
                        {
                            type: 'listbox',
                            name: 'slider_animation',
                            label: 'Animation',
                            'values': [
                                {text: 'Fade', value: 'fade'},
                                {text: 'Slide', value: 'slide'}
                            ]
                        },
                        // Slider speed
                        {
                            type: 'textbox',
                            name: 'slider_speed',
                            label: 'Speed (ms)',
                            value: '7000',
                            maxLength: '5',
                            tooltip: 'Set the speed of the slideshow, in milliseconds',
                        },
                        // Slider navigation
                        {
                            type: 'checkbox',
                            name: 'slider_navigation',
                            label: 'Show Navigation?',
                            checked: true
                        },
                        // Slider pagination
                        {
                            type: 'checkbox',
                            name: 'slider_pagination',
                            label: 'Show Pagination?',
                            checked: true
                        },
                        // Slider height
                        {
                            type: 'textbox',
                            name: 'slider_height',
                            label: 'Slider height (px)',
                            value: '',
                            maxLength: '5',
                            tooltip: 'Enter a fixed slider height, in pixel',
                        },
                        // Slider autoheight
                        {
                            type: 'checkbox',
                            name: 'slider_autoheight',
                            label: 'Auto-Height',
                            tooltip: 'Allow height of the slider to animate smoothly, in horizontal mode',
                            checked: false
                        },
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( 
                            '[i3-slideshow id="'
                            + e.data.slider_id + 
                            '" type="' 
                            + e.data.slider_type + 
                            '" category="' 
                            + e.data.slider_cat + 
                            '" exclude="'
                            + e.data.slider_exclude + 
                            '" animation="'
                            + e.data.slider_animation + 
                            '" speed="'
                            + e.data.slider_speed + 
                            '" navigation="' 
                            + e.data.slider_navigation + 
                            '" pagination="' 
                            + e.data.slider_pagination + 
                            '" height="' 
                            + e.data.slider_height + 
                            '" autoheight="'
                            + e.data.slider_autoheight + 
                            '"]<br/>');
                    }
                });
            },// END onclick
        }); // END editor...

    }); // END tinymce...
})();