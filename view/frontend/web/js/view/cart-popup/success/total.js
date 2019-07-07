define([
    'ko',
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Magento_Catalog/js/price-utils',
], function (ko, $, Component, customerData, priceUtils) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Onilab_CartPopup/cart-popup/success/total',
            code: false,
            title: '',
            showIfZero: false,
            priceFormat: null
        },
        isVisible: false,

        initialize: function() {
            // var result = this._super();
            // var cartData = customerData.get('cart');
            //
            // this.update(cartData());
            // cartData.subscribe(function (updatedCart) {
            //     this.update(updatedCart);
            // }.bind(this));
            //
            // this.isVisible = ko.computed(function() {
            //     return !!this.total().code &&
            //         (this.getValue() ||(this.getValue() === 0 && this.showIfZero));
            // }.bind(this));
            //
            // if(result.priceFormat){
            //     result.priceFormat = JSON.parse(result.priceFormat);
            // }
            //
            // return result;
        },

        initObservable: function () {
            return this._super()
                .observe('total', this.total)
                .observe('isVisible', false);
        },
        
        update: function(updatedCart) {
            // if (updatedCart['minicart_totals'] && updatedCart['minicart_totals'][this.code]) {
            //     this.total(updatedCart['minicart_totals'][this.code] || {});
            // } else {
            //     this.total({});
            // }
        },

        getFormattedPrice: function(price) {
            return priceUtils.formatPrice(price, this.priceFormat);
        },

        getCode: function() {
            return this.code;
        },

        getClassName: function() {
            return this.code.replace(/_/, '-');
        },

        getValue: function() {
            return this.total().value;
        },

        getTitle: function() {
            return this.title || this.total().title;
        }
    });
});
