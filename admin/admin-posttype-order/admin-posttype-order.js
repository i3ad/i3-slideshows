jQuery(function($) {

	$('.posts tbody').sortable({
		items: '> tr',
		axis: 'y',
		handle: '.column-menu_order',
		placeholder: 'column-menu_order-placeholder', // A class name that gets applied to the otherwise white space.
		forcePlaceholderSize: true, // If true, forces the placeholder to have a size.
		cursor: 'move', // Defines the cursor that is being shown while sorting.
		opacity: 0.8, // Defines the opacity of the helper while sorting.

		start: function(e, ui){ // find the right height
        	ui.placeholder.height(ui.item.height());
    	},

		update: function(event, ui) {

			var theOrder = $(this).sortable('toArray');

			var data = {
				action: 'i3sl_update_post_order',
				//postType: $(this).attr('data-post-type'),
				postType: 'i3_slide',
				order: theOrder
			};

			// Add an class only to the current sorted item
			//$(ui.item).on('sortupdate').addClass( 'my-testclass' );

			// Add a class to all items
			//$('tbody .column-menu_order').on('sortupdate').addClass( 'my-testclass' );
			$('tbody .column-menu_order').on('sortupdate').append( '<i class="fa fa-refresh fa-spin fa-3x"></i>' );

			//$.post(ajaxurl, data);
			$.post(ajaxurl, data,

				// Reload the admin page to display correct order (http://wordpress.stackexchange.com/questions/65157/how-to-reload-the-dashboard-after-clicking-update-in-quick-edit)
				function(r) {
					location.reload(); 
					//$( '.pages tbody .check-column' ).addClass( 'my-testclass' ); // Add a class to display loading
				}

			);
		} // End update

	}).disableSelection();

});