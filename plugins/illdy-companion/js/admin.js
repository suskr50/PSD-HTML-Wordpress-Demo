jQuery(document).ready(function(){
	jQuery('#demo_content .button').click(function(evt){
		evt.preventDefault();
		var currentButton = jQuery(this);
		jQuery(this).addClass('disabled');
		jQuery(this).next('.spinner').addClass('is-active');

		var ajaxData = { action: 'illdy_companion_import_content', import: jQuery(this).data('action') };

		jQuery.ajax({
            type       : "POST",
            data       : ajaxData,
            url        : illdyCompanion.ajaxurl,
            success    : function(data){
            	console.log(data);
            	if ( data == 'succes' ) {
            		currentButton.removeClass('disabled');
            		currentButton.next('.spinner').removeClass('is-active');
            		currentButton.parent().parent().find('.updated-message').show();
            	}
            },

        });

	});
});