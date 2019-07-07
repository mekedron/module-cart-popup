define([
    'uiComponent',
    'ko',
    'jquery',
    'mage/translate',
    'Onilab_CartPopup/js/model/cart-popup'
], function(Component, ko, $, $t, cartPopupModel) {
    'use strict';

    // @TODO add jsDoc

    return Component.extend({
        defaults: {
            template: 'Onilab_CartPopup/cart-popup',
            priceFormat: null
        },
        modalWindow: null,
        addedItem: cartPopupModel.addedItem,
        optionsBlock: cartPopupModel.optionsBlock,

        initialize: function() {
            this._super();
        },

        setModalElement: function (element) {
            if (cartPopupModel.modalWindow == null) {
                cartPopupModel.createPopUp(element, {
                    // @TODO refactor title
                    title: $t('Loading...'),
                    modalTitle: '.cart-popup [data-role="title"]',

                    buttons: [{
                        text: $t('Close'),
                        class: 'action-secondary action-save'
                    }, {
                        text: $t('View and Edit Cart'),
                        class: 'action-primary action-save',
                        click: function() {
                            window.location = this.cartUrl
                        }
                    }]
                });
            }
        },

        closeModal: function (uiClass, e) {
            e.preventDefault();
            cartPopupModel.closeModal();
        },

        triggerContentUpdated: function (element) {
            $(element).trigger('contentUpdated');
        }
    });
});
