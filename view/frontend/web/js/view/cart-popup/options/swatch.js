define([
    'jquery',
    'mage/translate',
    'Magento_Swatches/js/swatch-renderer'
], function ($, $t) {
    'use strict';

    $.widget('onilab.CartPopupSwatchRenderer', $.mage.SwatchRenderer, {
        options: {
            enableControlLabel: false,
            defaultBaseImage: '',
        },

        updateBaseImage: function(images) {
            if (images.length) {
                // update image
                $(this.options.mediaGallerySelector).attr('src', getThumb())
            }

            function getThumb() {
                var image = '';

                for (var i in images) {
                    if (images[i].isMain) {
                        image = getUrl(images[i]);
                    }
                }

                function getUrl(image) {
                    return image.img || image.full;
                }

                return image || getUrl(images[0]);
            }
        }
    });

    return $.onilab.CartPopupSwatchRenderer;
});
