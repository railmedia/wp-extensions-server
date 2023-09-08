import $ from 'jquery';
import 'js-loading-overlay';

(function($) {

    const UniqueValue = {

        createExtensionSlug: async (title = '', slug = '') => {

            JsLoadingOverlay.show();

            await axios({
                url: '/services/unique-value',
                method: 'post',
                data: {
                    title: title,
                    slug: slug,
                    type: 'extension-slug'
                },
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then( response => {

                JsLoadingOverlay.hide();
                
                jQuery('#slug').val( response.data );
    
            });

        }
    }

    if( $('.create-edit-extension').length ) {

        jQuery('#name').on('change', function() {
            if( ! jQuery('#slug').val() ) {
                UniqueValue.createExtensionSlug( jQuery(this).val() );
            }
        });

        jQuery('#slug').on('change', function() {
            alert('Please be advised that when you change the slug, you will need to move the extensions\' files into the new folder that needs to have the same name of the slug.');
            UniqueValue.createExtensionSlug( jQuery(this).val() );
        });

    }

})(jQuery);