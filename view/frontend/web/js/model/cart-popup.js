define([
    'ko',
    'jquery',
    'underscore',
    'Magento_Ui/js/modal/modal',
    'Magento_Ui/js/modal/alert',
    'mage/translate',
    'Magento_Customer/js/customer-data'
], function (ko, $, _, modal, uiAlert, $t, customerData) {
    'use strict';

    var addedItems = ko.observable(null);

    // @TODO refactor
    // @TODO make it works with related, crossels and upsells
    // @TODO doesn't work in hot sells

    return {
        modalWindow: null,

        relatedProductsBlock: ko.observable(null),

        optionsBlock: ko.observable(null),

        addedItems: ko.computed(function () {
            var cartData = customerData.get('cart');
            var foundItems = [];
            var addedItemsIds = [];

            if (!addedItems()) {
                return null;
            }

            // @TODO refactor this someday
            if ($.isArray(cartData().items)) {
                addedItemsIds = _.map(addedItems(), function (item) {
                    return item.item_id
                });

                foundItems = _.values($.extend(true, {}, cartData().items));

                foundItems = _.filter(foundItems, function (item) {
                    // Yeah, we just could make a check like "> -1" or "!== -1", but I found it nicer,
                    // because we can use exactly same function here and below, hahahaha
                    return addedItemsIds.indexOf(item.item_id) + 1;
                });

                foundItems = _.sortBy(foundItems, function (item) {
                    return addedItemsIds.indexOf(item.item_id) + 1;
                });
            }

            return foundItems.length ? foundItems : null;
        }),

        // @TODO create popup after first call
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

        bindAddToCartHandler: function () {
            // we want to call this after all the others events
            // because we can destroy the configurable cart-popup add to cart form
            $(document).on(
                'ajax:addToCart',
                setTimeout.bind(window, this.handleResponse.bind(this), 0)
            );

            return this;
        },

        handleResponse: function (event, data) {
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
                    data.response.added_items,
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

        showOptionsModal: function (optionsBlock) {
            this.setModalTitle($t('Please select configuration.'));
            this.setAddedItems(null);
            this.setRelatedProductsBlock(null);
            this.setOptionsBlock(optionsBlock);
            this.showModal();

            return this;
        },

        showSuccessModal: function (addedItems, relatedProductsBlock) {
            // @TODO add product name here
            this.setModalTitle($t('The article has been added to your cart.'));
            this.setAddedItems(addedItems);
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
            this.setAddedItems(null);
            this.setRelatedProductsBlock(null);
            this.setOptionsBlock(null);

            return this;
        },

        setModalTitle: function (title) {
            $(this.modalWindow).modal('setTitle', title);

            return this;
        },

        setAddedItems: function (item, invalidateCart) {
            addedItems(item);

            if (invalidateCart) {
                customerData.set('cart', {});
                customerData.invalidate(['cart']);
            }

            return this;
        },

        setRelatedProductsBlock: function (data) {
            this.relatedProductsBlock(data || null);

            return this;
        },

        setOptionsBlock: function (data) {
            this.optionsBlock(data || null);

            return this;
        }
    };
});
