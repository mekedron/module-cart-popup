define([
    'uiComponent',
    'ko',
    'jquery',
    'mage/translate',
    'Onilab_CartPopup/js/model/cart-popup',
    'mage/cookies'
], function(Component, ko, $, $t, cartPopupModel) {

    return Component.extend({
        defaults: {
            template: 'Onilab_CartPopup/cart-popup/options'
        },

        optionsBlock: cartPopupModel.optionsBlock,

        init: function (element) {
            $(element).trigger('contentUpdated');
            $(element).find('input[name=form_key]').val($.mage.cookies.get('form_key'));
        }
    });
});
