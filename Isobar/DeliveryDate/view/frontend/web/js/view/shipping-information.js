/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'jquery',
        'Magento_Checkout/js/view/shipping-information'
        // 'uiRegistry'
    ],
    function($, shipping) {
        'use strict';
        return shipping.extend({
            defaults: {
                template: 'Isobar_DeliveryDate/shipping-information'
            },

            deliveryInfo: null,

            initialize: function() {
                this._super();
                // this.deliveryInfo = registry.get(this.provider + '.shippingAdditional.additional_block');

                return this;
            },

            getDeliveryDate: function() {
                return this.deliveryInfo.delivery_date;
            },
            getDeliveryComment: function() {
                return this.deliveryInfo.delivery_comment;
            }
        });
    }
);
