define([
    'ko'
], function (ko) {
    'use strict';

    var deliveryDate = ko.observable(null);

    return {
        deliveryDate:

            deliveryDate,

            setDeliveryDate: function(delivery) {
                deliveryDate(delivery);
            }
    };
});
