define([
    'jquery',
    'isobarNewsletterFancybox'
], function ($) {
    "use strict";

    var isobarNewsletter = {
        cookieName: "isobar_newsletter",

        getCookie: function () {
            var name = this.cookieName;
            var nameEQ = escape(name) + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) {
                    return unescape(c.substring(nameEQ.length, c.length));
                }
            }
            return null;
        },

        createCookie: function () {
            var days = 1;
            var value = 1;
            var name = this.cookieName;

            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            // console.log(date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)))
            var expires = "; expires=" + date.toGMTString();

            document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
            console.log(expires)
        }
    };

    return {
        displayTemplate: function (element) {

            if (isobarNewsletter.getCookie() != 1) {
                isobarNewsletter.createCookie();
                $(element).click();
            }

        }
    };
});