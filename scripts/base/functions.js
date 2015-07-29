
function loadParallax() {
    $('.ball-1, .ball-2, .ball-3').bind('inview', function (event, visible) {
        if (visible == true) {
            parallax();                     // calcul au chargement de la page
            $(window).scroll(parallax);     // calcul au défilement de la page
            $(window).resize(parallax);     // calcul au redimensionnement de la page
        }
    });
}



function getWindowHeight() {
    var windowHeight=0;
    if (typeof(window.innerHeight)=='number') {
        windowHeight=window.innerHeight;
    } else {
        if (document.documentElement && document.documentElement.clientHeight) {
            windowHeight = document.documentElement.clientHeight;
        } else {
            if (document.body && document.body.clientHeight) {
                windowHeight=document.body.clientHeight;
            }
        }
    }
    return windowHeight;
}



function parallax(){
    scrollTopCur = $(document).scrollTop(); // distance par rapport au haut du document
    heightCur = $(document).height();       // hauteur du document
    windowHeight = getWindowHeight();       // hauteur "utile" de la fenêtre

    $('.ball-1').css(
        "background-position",
        "5% " +
        Math.round(windowHeight - 3150 - (scrollTopCur + windowHeight - heightCur) / 0.5)
        + "px"
    );
    $('.ball-2').css(
        "background-position",
        "22% " +
        Math.round(windowHeight - 980 - (scrollTopCur + windowHeight - heightCur) / 4)
        + "px"
    );
    $('.ball-3').css(
        "background-position",
        "23% " +
        Math.round(windowHeight - 915 - (scrollTopCur + windowHeight - heightCur) / 2)
        + "px"
    );
    $('.ball-4').css(
        "background-position",
        "53% " +
        Math.round(windowHeight - 3266 - (scrollTopCur + windowHeight - heightCur) / 0.5)
        + "px"
    );
    $('.ball-5').css(
        "background-position",
        "60% " +
        Math.round(windowHeight - 1060 - (scrollTopCur + windowHeight - heightCur) / 1.5)
        + "px"
    );
    $('.ball-6').css(
        "background-position",
        "80% " +
        Math.round(windowHeight - 3150 - (scrollTopCur + windowHeight - heightCur) / 0.5)
        + "px"
    );
    $('.ball-7').css(
        "background-position",
        "90% " +
        Math.round(windowHeight - 1400 - (scrollTopCur + windowHeight - heightCur) / 1.5)
        + "px"
    );
}


function topLevelDropDownActive(){
    // Bootstrap menu magic
    if (jQuery(window).width() < 768) {
        jQuery(".dropdown-toggle").attr('data-toggle', 'dropdown');
    } else {
        jQuery(".dropdown-toggle").removeAttr('data-toggle dropdown');
    }
}


function dropdownHoverActive(){
    $('.dropdown').hover(function() {
            $(this).addClass('open');
        }, function() {
            $(this).removeClass('open');
    });
}


function embedResponsive(){
    $('iframe').wrap("<div class='video-container'></div>");
}


function flexiselSlider(){
    $(window).load(function() {
        $(".flexiselSlider").flexisel({
            visibleItems: 4,
            animationSpeed: 200,
            autoPlay: false,
            autoPlaySpeed: 3000,
            pauseOnHover: true,
            clone:false,
            enableResponsiveBreakpoints: true,
            responsiveBreakpoints: {
                portrait: {
                    changePoint:480,
                    visibleItems: 1
                },
                landscape: {
                    changePoint:640,
                    visibleItems: 2
                },
                tablet: {
                    changePoint:768,
                    visibleItems: 3
                }
            }
        });
    });
}