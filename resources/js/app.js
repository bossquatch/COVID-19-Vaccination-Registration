$(document).ready(function () {
    // Check if browser is Internet Explorer
    detectIE();

    // Function to check if browser is Internet Explorer, if so, redirects to an IE is not supported page
    function detectIE() {
        var ua = window.navigator.userAgent;

        var msie = ua.indexOf('MSIE ');
        var trident = ua.indexOf('Trident/');
        var edge = ua.indexOf('Edge/');

        if (msie > 0 || trident > 0 || edge > 0) {
            // IE 10 or older, IE 11, or Edge (IE 12+) => redirect to IE is not supported page
            window.location.replace("/not-supported");
            return true;
        }

        // Other browser
        return false;
    }

    if (!String.prototype.startsWith) {
        Object.defineProperty(String.prototype, 'startsWith', {
            value: function (search, rawPos) {
                var pos = rawPos > 0 ? rawPos | 0 : 0;
                return this.substring(pos, pos + search.length) === search;
            }
        });
    }

    if (!String.prototype.endsWith) {
        String.prototype.endsWith = function (search, this_len) {
            if (this_len === undefined || this_len > this.length) {
                this_len = this.length;
            }
            return this.substring(this_len - search.length, this_len) === search;
        };
    }

    function includes(container, value) {
        var returnValue = false;
        var pos = container.indexOf(value);
        if (pos >= 0) {
            returnValue = true;
        }
        return returnValue;
    }

    $(window).scroll(function () {
        $('.navbar-color-on-scroll').toggleClass('navbar-transparent', $(this).scrollTop() < $('.navbar-color-on-scroll').attr("color-on-scroll"));
    })
});