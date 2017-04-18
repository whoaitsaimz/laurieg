// jqueryslidemenu.js
// jquery.tools.tabs.min.js
// jquery.colorbox-min.js
// jquery.swfobject.1-1-1.min.js"
// video.js"
// jquery.nivo.slider.pack.js"
// jquery.easing.1.3.js"
// jquery.kwicks-1.5.1.pack.js"
// jquery.anythingslider.js"
// jquery.quicksand.js"
// jquery.tools.validator.min.js"

// Avoid `console` errors in browsers that lack a console.
(function () {
    var method;
    var noop = function noop() {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());
