define([
    'ko',
    'jquery',
    'Magento_Ui/js/modal/modal',
    'Magento_Ui/js/modal/alert',
    'mage/translate',
    'Magento_Customer/js/customer-data'
], function (ko, $, modal, uiAlert, $t, customerData) {
    'use strict';

    var addedItemId = ko.observable(null);

    // @todo refactor

    return {
        modalWindow: null,

        relatedProductsBlock: ko.observable(null),

        optionsBlock: ko.observable(null),

        addedItem: ko.computed(function() {
            var cartData = customerData.get('cart');
            var foundItem = null;

            if (!addedItemId()) {
                return null;
            }

            if ($.isArray(cartData()['items'])) {
                cartData().items.forEach(function(item) {
                    if (foundItem === null &&
                        item.item_id === addedItemId()
                    ) {
                        foundItem = item;
                    }
                }.bind(this));
            }

            return foundItem;
        }),

        createPopUp: function (element, options) {
            options = $.extend({
                'type': 'popup',
                'modalClass': 'cart-popup',
                'buttons': []
            }, options || {});

            this.modalWindow = element;
            modal(options, $(this.modalWindow));
            this.bindAddToCartHandler();

            return this;
        },

        bindAddToCartHandler: function() {
            // we want to call this after all the others events
            // because we can destroy the configurable cart-popup add to cart form
            $(document).on(
                'ajax:addToCart',
                setTimeout.bind(window, this.handleResponse.bind(this), 0)
            );

            return this;
        },

        handleResponse: function(event, data) {
            if (!data.response) {
                this.closeModal();
                return;
            }

            if (data.response.success === false &&
                data.response.options_block
            ) {
                this.showOptionsModal(data.response.options_block);

                return;
            }

            if (data.response.success === true) {
                this.showSuccessModal(
                     data.response.item_id,
                    data.response.related_products_block || '',
                    data.response.options_block || ''
                );

                return;
            }

            this.showError(data.response.messages);

            return this;
        },

        showError: function (messages) {
            uiAlert({
                title: $t('Attention!'),
                content: messages.map(function (message) {
                    return (
                        '<div class="message-' + message.type + ' ' + message.type + ' message">' +
                        '<div>' + message.text + '</div>' +
                        '</div>'
                    );
                })
            });

            return this;
        },

        showOptionsModal: function(optionsBlock) {
            this.setModalTitle($t('Please select configuration.'));
            this.setAddedItem(null);
            this.setRelatedProductsBlock(null);
            this.setOptionsBlock(optionsBlock);
            this.showModal();

            return this;
        },

        showSuccessModal: function (itemId, relatedProductsBlock) {
            // @TODO add product name here
            this.setModalTitle($t('The article has been added to your cart.'));
            this.setAddedItem(itemId);
            this.setRelatedProductsBlock(relatedProductsBlock);
            this.setOptionsBlock(null);
            this.showModal();

            return this;
        },

        showModal: function () {
            $(this.modalWindow)
                .modal('openModal')
                .trigger('contentUpdated');

            return this;
        },

        closeModal: function () {
            $(this.modalWindow).modal('closeModal');
            this.setAddedItem(null);
            this.setRelatedProductsBlock(null);
            this.setOptionsBlock(null);

            return this;
        },

        setModalTitle: function (title) {
            $(this.modalWindow).modal('setTitle', title);

            return this;
        },

        setAddedItem: function(item, invalidateCart) {
            addedItemId(item);

            if (invalidateCart) {
                customerData.set('cart', {});
                customerData.invalidate(['cart']);
            }

            return this;
        },

        setRelatedProductsBlock: function(data) {
            this.relatedProductsBlock(data || null);

            return this;
        },

        setOptionsBlock: function(data) {
            this.optionsBlock(data || null);

            return this;
        }
    };
});
