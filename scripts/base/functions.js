
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

function centered_block(){

    var div_centered  = jQuery('.centered-block');
    div_centered.each(function(){
        var div_height  = jQuery(this).outerHeight();
        var div_width  = jQuery(this).outerWidth();
        console.log(div_height);
        console.log(div_width);
        jQuery(this).css('marginTop',-div_height/2);
        jQuery(this).css('marginLeft',-div_width/2);
    });

}

function fixHeight(elem){
    var maxHeight = 0;
    jQuery(elem).css('height','auto');
    jQuery(elem).each(function(){
        if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
    });
    jQuery(elem).height(maxHeight);
}

function isMobile(){
    var isMobile = false; //initiate as false
// device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

    return isMobile;
}

var functions = {
    offsetHeader: 0,
    pageScroll: function (_tag) {
        var _totalScroll = jQuery(_tag).offset().top - functions.offsetHeader;
        jQuery('html,body').animate({
            scrollTop: _totalScroll
        }, 1000);
    },
};

function pageScroll(_tag) {
    log($(_tag).offset());
    if (typeof $(_tag).offset() !== 'undefined') {
        var _totalScroll = $(_tag).offset().top-110;
        console.log(_tag);
        $('html,body').animate({
            scrollTop: _totalScroll
        }, 1000);
    }
}

function log() {
    var _args = Array.prototype.slice.call(arguments);
    if (this.debug) {
        if (typeof console !== "undefined" || typeof console.log !== "undefined") {
            console.log(_args);
        }
    }
}

/* ---------------------------------------------------------------------------
 * changeLang
 * --------------------------------------------------------------------------- */

// function changeLang()
// {
// 	jQuery('.pays li a').click(function(e)
// 	{
// 		e.preventDefault();
// 		var pays = this.id;
// 		var url = jQuery(this).attr('href');
// 		if(jQuery('input[name=save_pays]').is(':checked')){

// 			jQuery.cookie('pays', pays, {
// 			    expires : 365,
// 			    path : '/'
// 			});

// 		}else{
// 			//console.log('pas ok');
// 			document.location.href= url+'/'+pays;
// 		}
// 	});
// }

/* ---------------------------------------------------------------------------
 * lastItem
 * --------------------------------------------------------------------------- */

function lastItem(class_name,col,size){
    var size = size || "17px";

    jQuery(class_name).each(function(a,b){
        //console.log(b);

        if( ((a+1) % col) === 0){
            jQuery(b).css('margin-right','0px');
            //jQuery(b).next().css('clear','both');
        }else{
            jQuery(this).css('margin-right',size).css('clear','none');
        }
    });
}

/* ---------------------------------------------------------------------------
 *  FilterIsotope
 * --------------------------------------------------------------------------- */

function FilterIsotope(){
    // init Isotope
    var container = jQuery('#main-promotion').isotope({
        // options
    });
    // filter items on button click
    jQuery('#filters').on( 'click', 'a', function() {

        jQuery('.one-sidebare .options #filters li a').removeClass('selected');
        var filterValue = jQuery(this).attr('data-filter');
        jQuery(this).addClass('selected');
        container.isotope({ filter: filterValue });

    });
}

function EventIsotope(){
    // init Isotope
    var container = jQuery('#main-event').isotope({
        // options
    });
    // filter items on button click
    jQuery('#filters').on( 'click', 'a', function() {

        jQuery('.one-sidebare .options #filters li a').removeClass('selected');
        var filterValue = jQuery(this).attr('data-filter');
        jQuery(this).addClass('selected');
        container.isotope({ filter: filterValue });

    });
}

/* ---------------------------------------------------------------------------
 *  show code promo
 * --------------------------------------------------------------------------- */

function show_code(){
    jQuery('.show_code').click(function(e){
        //console.log(e);
        jQuery(e.currentTarget).parent('.cat-sufix').children('.show_code_hide').slideDown('fast');
    });
    jQuery('.show_code_close').click(function(e){
        //console.log(e);
        jQuery('.show_code_hide').slideUp('fast');
    });

}

/* ---------------------------------------------------------------------------
 *  increment number of click on promo code
 * --------------------------------------------------------------------------- */

function increment_views(postID){

    // had to add the post id to the permalink in loop as url to postid didn't work
    var postID = postID;
    var ajax_url = "http://dev2.indexel.com/agilentcom/wp-admin/admin-ajax.php";
    // console.log(postID);
    var data = {
        action: 'inc_views',
        post_id: postID
    };
    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post(ajax_url, data, function(response) {
        //update the custom field value without a page refresh
        console.log('jquerypost');

    });

}


/* ---------------------------------------------------------------------------
 *  CREAT COOKIE
 * --------------------------------------------------------------------------- */
function creatCookie(name,value,minutes){

    var date = new Date();
    var minutes = minutes;
    date.setTime(date.getTime() + (minutes * 60 * 1000));
    jQuery.cookie(name, value, {expires : date });

}

/* ---------------------------------------------------------------------------
 *  CHECK CLICK  ON CODE PROMOTION
 * --------------------------------------------------------------------------- */
function checkClick(){
    jQuery('.show_code').click(function(event) {
        var postID = jQuery(this).attr('id');
        var Cookie = jQuery.cookie('promo_code_'+postID);
        var date = new Date();

        if (Cookie == null) {
            //CREAT COOKIES
            console.log('NULL');
            creatCookie('promo_code_'+postID,'ok',1);
            increment_views(postID);
        }
        return false;
    });
}
/* ---------------------------------------------------------------------------
 *  addthis change icon size for 32px
 * --------------------------------------------------------------------------- */

function Addthis_Change_Icon_Size(size){
    // jQuery('.main-share .share .addthis_toolbox').removeClass('addthis_default_style');
    jQuery('.main-share .share .addthis_toolbox').addClass(size);
}

/* ---------------------------------------------------------------------------
 *  Contact form 7   jQuery('.wpcf7-show').val().length == 0
 * --------------------------------------------------------------------------- */
function cf7_helper(){

    jQuery('.my-radio .wpcf7-radio span:nth-child(2) label').append('<input type="text" name="show-radio" value="" class="wpcf7-show">');
    jQuery('.wpcf7-show').css('marginLeft','5px');

    jQuery('.my-radio .wpcf7-radio span:nth-child(2) input').click(function(){
        jQuery('.my-radio .wpcf7-radio span:nth-child(2) input[type="radio"]').attr('checked', true);
        trigger_after_typing_input();
    });
}

function trigger_after_typing_input(){
    var timeoutReference;
    jQuery('input.wpcf7-show').keypress(function() {
        var _this = jQuery(this); // copy of this object for further usage

        if (timeoutReference) clearTimeout(timeoutReference);
        timeoutReference = setTimeout(function() {
            jQuery(".wpcf7-hidden").val(_this.val());
        }, 3000);
    });
}

function checkedcf7(){
    jQuery('.my-radio .wpcf7-radio span:nth-child(2) input, .my-radio .wpcf7-radio span:nth-child(1) input, .my-radio .wpcf7-radio span:nth-child(3) input').change(function(){

        console.log(jQuery('.my-radio .wpcf7-radio span:nth-child(1) input[type="radio"]').length);
        console.log(jQuery('.my-radio .wpcf7-radio span:nth-child(2) input[type="radio"]').length);
        console.log(jQuery('.my-radio .wpcf7-radio span:nth-child(3) input[type="radio"]').length);
        if(jQuery('.my-radio .wpcf7-radio span:nth-child(1) input').is(':checked') || jQuery('.my-radio .wpcf7-radio span:nth-child(3) input').is(':checked') ){

            //alert('ok');
            //trigger_after_typing_input();
            jQuery('.wpcf7-show').val('');
            jQuery(".wpcf7-hidden").val('');
            jQuery('.my-radio .wpcf7-radio span:nth-child(2) input[type="radio"]').attr('checked', false);
        }else{


        }
    });
}

/* ---------------------------------------------------------------------------
 *  Get variable from URL
 * --------------------------------------------------------------------------- */
function urlParam (name){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == name)
        {
            return sParameterName[1];
        }
    }
}

function decodeURI(url){
    return decodeURIComponent(url);
}



/* ---------------------------------------------------------------------------
 *  Sticky Menu
 * --------------------------------------------------------------------------- */
function sticky_menu(id){
    jQuery(window).scroll(function(){
        var scroll = jQuery(window).scrollTop();
        //console.log	(scroll);
        jQuery(id).css('top' , scroll +'px');
    });
}


/* ---------------------------------------------------------------------------
 *  Scroll Top
 * --------------------------------------------------------------------------- */

function scrollTop(id){
    jQuery(window).scroll(function(){
        if (jQuery(this).scrollTop() > 100) {
            jQuery(id).fadeIn();
        } else {
            jQuery(id).fadeOut();
        }
    });

    //Click event to scroll to top
    jQuery(id).click(function(){
        jQuery('html, body').animate({scrollTop : 0},800);
        return false;
    });
}

/* ---------------------------------------------------------------------------
 *  Scroll To Hash With Change page
 * --------------------------------------------------------------------------- */


function scrollToOnChangePage(){
    var split = jQuery(location).attr('href').split('?');
    //console.log('toto' + split);
    setTimeout(function(){
        var currentHash = "#"+split[1];
        if (currentHash) {
            var currentHashPos = jQuery(currentHash).offset().top;
        }

        //console.log(currentHashPos);
        jQuery('html, body').animate({scrollTop : currentHashPos}, 400,'swing');
    }, 100);
}

/* ---------------------------------------------------------------------------
 *  	FInd Us
 *
 * 	addClassFindUsItem
 *  	add class pour les onglets avec un Item
 *
 * 	scrollTopFindUS
 * 	scroll pour les onglets
 * --------------------------------------------------------------------------- */
function addClassFindUsItem(){

    jQuery(".resp-tab-content").each(function(){
        var nbChild = jQuery(this).children('div').length;
        //console.log(nbChild);
        if (nbChild == 1) {
            jQuery(this).addClass('oneColumn');
        };
    });

}

function scrollTopFindUS(){
    //Click event to scroll to top
    jQuery('.resp-tab-item').click(function(){
        jQuery('html, body').animate({scrollTop : 200},800);
        return false;
    });
}

/* ---------------------------------------------------------------------------
 *  Clone le lien d'un element
 * --------------------------------------------------------------------------- */
function cloneLink(element,hit,value){
    var e = jQuery(element).attr('href');
    var h = jQuery(hit);

    h.attr(value, e);

}

/* ---------------------------------------------------------------------------
 *  EXTRAIRE LE CODE HTML
 * --------------------------------------------------------------------------- */

function get_dom(){
    var head = jQuery('#head').html();

    var dom = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

    dom += '<html xmlns="http://www.w3.org/1999/xhtml">';
    dom += '<body>';

    dom += '<head>';
    dom += head;
    dom += '</head>';

    dom += jQuery("#content").html();
    dom += '</body>';
    dom += '</html>';

    //jQuery('#content-newsletter').hide();
    /* jQuery('#extract-html').click(function(event) {
     jQuery('#content-newsletter').text(dom);
     jQuery('#move').animate({left: "37px"}, 400);
     //jQuery('#content-newsletter').toggle(50);
     // alert(dom);
     }); */

    /* jQuery('#closeblock').click(function(event) {
     jQuery('#move').animate({left: "-538px"}, 400);
     }); */

    var x = false
    jQuery('#extract-html, #closeblock').on('click', function(event){
        if (!x){
            jQuery('#content-newsletter').text(dom);
            jQuery('#move').animate({left: "37px"}, 400);
            x = true;
        }
        else {
            jQuery('#move').animate({left: "-538px"}, 400);
            x = false;
        }
    });


}
// cleanCategory('#nav_menu-3 .menu a');
function cleanCategory(target){

    jQuery(target).each(function(index, el) {
        var text 	= jQuery(this).text();
        var split 	= text.split('@');
        jQuery(this).text(split[0]);
        // console.log(split[0]);
    });


}

function cleanIsotopeFilter(){
    jQuery('.item-non-classe-2').hide();
    jQuery('.page-template-page-promotions-php .item-tous-les-produits').hide();
    jQuery('.page-template-page-events-php .item-tous-les-produits').hide();

}

// Link to Store
function linkToStore(){
    var url = "http://www.chem.agilent.com/en-US/Contact-US/Pages/ContactUs.aspx";

    jQuery('.findus-item a,.findus-link a').attr('href', url);

}

