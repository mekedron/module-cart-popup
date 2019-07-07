define([
    'uiComponent',
    'ko',
    'jquery',
    'mage/translate',
    'Onilab_CartPopup/js/model/cart-popup',
    'Magento_Customer/js/customer-data',
    'Magento_Catalog/js/price-utils'
], function(Component, ko, $, $t, cartPopupModel, customerData, priceUtils) {
    return Component.extend({
        defaults: {
            template: 'Onilab_CartPopup/cart-popup/success',
            priceFormat: null,
            cartUrl: ''
        },
        addedItem: cartPopupModel.addedItem,
        relatedProductsBlock: cartPopupModel.relatedProductsBlock,
        swatchBlock: cartPopupModel.swatchBlock,

        title: ko.computed(function() {
            var cartData = customerData.get('cart');

            return $t('You have <b>%1 items</b> in your shopping cart.')
                .replace('%1', (cartData().summary_count || '...'));
        }),

        getFormattedPrice: function (price) {
            return priceUtils.formatPrice(price, this.priceFormat);
        }
    });
});
