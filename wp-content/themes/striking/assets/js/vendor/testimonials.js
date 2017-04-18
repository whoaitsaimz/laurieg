 jQuery(document).ready(function() {
    // create the image rotator
    setInterval("rotateImages()", 3500);
    setInterval("rotateImages2()", 3500);
    setInterval("rotateImages3()", 3500);
    });

    function rotateImages() {
        var oCurPhoto = jQuery('.photoShow div.current');
        var oNxtPhoto = oCurPhoto.next();
        if (oNxtPhoto.length == 0)
            oNxtPhoto = jQuery('.photoShow div:first');

        oCurPhoto.removeClass('current').addClass('previous');
        oNxtPhoto.css({ opacity: 0.0 }).addClass('current').animate({ opacity: 1.0 }, 2000,
            function() {
                oCurPhoto.removeClass('previous');
            });
    }

    function rotateImages2() {
        var oCurPhoto = jQuery('.photoShow2 div.current');
        var oNxtPhoto = oCurPhoto.next();
        if (oNxtPhoto.length == 0)
            oNxtPhoto = jQuery('.photoShow2 div:first');

        oCurPhoto.removeClass('current').addClass('previous');
        oNxtPhoto.css({ opacity: 0.0 }).addClass('current').animate({ opacity: 1.0 }, 2000,
            function() {
                oCurPhoto.removeClass('previous');
            });
    }

    function rotateImages3() {
        var oCurPhoto = jQuery('.photoShow3 div.current');
        var oNxtPhoto = oCurPhoto.next();
        if (oNxtPhoto.length == 0)
            oNxtPhoto = jQuery('.photoShow3 div:first');

        oCurPhoto.removeClass('current').addClass('previous');
        oNxtPhoto.css({ opacity: 0.0 }).addClass('current').animate({ opacity: 1.0 }, 2000,
            function() {
                oCurPhoto.removeClass('previous');
            });
    }