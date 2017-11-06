define([
    'jquery',
    'ko',
    'uiComponent',
    'Isobar_DeliveryDate/js/model/deliverydatemodel'
], function ($, ko, Component, model) {
    'use strict';

    var de;

    return Component.extend({
        delivery_date: ko.observable(''),
        delivery_comment: ko.observable(''),

        defaults: {
            template: 'Isobar_DeliveryDate/form/deliverydate'
        },

        initialize: function () {
            this._super();

            ko.bindingHandlers.datetimepicker = {
                init: function (element) {
                    var $el = $(element);
                    var options = {
                        minDate: new Date(),
                        dateFormat: 'dd-mm-yy',
                        timeFormat: '',
                        showTime: false,
                        showHour: false,
                        showMinute: false
                    };
                    $el.datetimepicker(options);
                }
            };

            de = window.checkoutConfig.deliveryDateSSDB;
            this.delivery_date(de.delivery_date);
            this.delivery_comment(de.delivery_comment);
            model.setDeliveryDate(de);

            this.delivery_date.subscribe(function (newdate) {
                de.delivery_date = newdate;
                model.setDeliveryDate(de);
            });

            this.delivery_comment.subscribe(function (newcomment) {
                de.delivery_comment = newcomment;
                model.setDeliveryDate(de);
            });
        }
    });
});