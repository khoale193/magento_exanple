define([
    'jquery',
    'ko',
    'uiComponent',
    'Isobar_DeliveryDate/js/model/deliverydatemodel'
], function ($, ko, Component, model) {
    'use strict';
    var self;
    return Component.extend({
        defaults: {
            template: 'Isobar_DeliveryDate/summary/deliverydate'
        },
        deliveryDate: ko.observable(''),
        deliveryComment: ko.observable(''),

        initialize: function () {
            this._super();

            self = this;
            this.deliveryDate(model.deliveryDate().delivery_date);
            this.deliveryComment(model.deliveryDate().delivery_comment);

            model.deliveryDate.subscribe(function (deliveryDate) {
                // if (typeof(deliveryDate) != 'undefined') {
                    self.setShiptoExt(deliveryDate);
                // }
            });

            return this;
        },

        setShiptoExt: function (deliveryDate) {
            this.deliveryDate(deliveryDate.delivery_date);
            this.deliveryComment(deliveryDate.delivery_comment);
        }
    });
});