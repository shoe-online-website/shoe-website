$(document).mouseup(function(e){
    var container = $(".suggestions");
    // If the target of the click isn't the container
    if(!container.is(e.target) && container.has(e.target).length === 0){
        container.hide();
    }
});
(function($) {"use strict";
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	}

	function backgroundImage() {
		var databackground = $('[data-background]');
		databackground.each(function() {
			if ($(this).attr('data-background')) {
				var image_path = $(this).attr('data-background');
				$(this).css({
					'background': 'url(' + image_path + ')'
				});
			}
		});
	}

	function parallax() {
		$('.bg--parallax').each(function() {
			var el = $(this),
				xpos = "50%",
				windowHeight = $(window).height();
			if (isMobile.any()) {
				$(this).css('background-attachment', 'scroll');
			} else {
				$(window).scroll(function() {
					var current = $(window).scrollTop(),
						top = el.offset().top,
						height = el.outerHeight();
					if (top + height < current || top > current + windowHeight) {
						return;
					}
					el.css('backgroundPosition', xpos + " " + Math.round((top - current) * 0.2) + "px");
				});
			}
		});
	}

	function menuBtnToggle() {
		var toggleBtn = $('.menu-toggle'),
			sidebar = $('.header--sidebar'),
			menu = $('.menu'),
			overplaybody = $('#overplaybody'),
			bodyactive = $('body');
		toggleBtn.on('click', function(event) {
			var self = $(this);
			self.toggleClass('active');
			bodyactive.toggleClass('activebody');
			overplaybody.toggleClass('active');
			$('.ps-main, .header').toggleClass('menu--active');
			sidebar.toggleClass('active');
		});
	}

	function menuBtnToggleOverPlay() {
		var toggleBtnOverplay = $('#overplaybody'),
			sidebar = $('.header--sidebar'),
			menu = $('.menu'),
			toggleBtn = $('.menu-toggle'),
			bodyactive = $('body');
		toggleBtnOverplay.on('click', function(event) {
			var self = $(this);
			self.toggleClass('active');
			bodyactive.toggleClass('activebody');
			toggleBtn.toggleClass('active');
			$('.ps-main, .header').toggleClass('menu--active');
			sidebar.toggleClass('active');
		});
	}

	function subMenuToggle() {
		$('body').on('click', '.header--sidebar .menu .menu-item-has-children > a', function(event) {
			event.preventDefault();
			var current = $(this).parent('.menu-item-has-children')
			current.children('.sub-menu').slideToggle(200);
			current.children('.mega-menu').slideToggle(200);
			current.siblings().find('.sub-menu').slideUp(200);
			current.siblings().find('.mega-menu').slideUp(200);
		});
		$('body').on('click', '.menuCateMobile .menu .menu-item-has-children > a', function(event) {
			event.preventDefault();
			var current = $(this).parent('.menu-item-has-children')
			current.children('.sub-menu').slideToggle(200);
			current.children('.mega-menu').slideToggle(200);
			current.siblings().find('.sub-menu').slideUp(200);
			current.siblings().find('.mega-menu').slideUp(200);
		});
	}

	function resizeHeader() {
		var header = $('.header'),
			headerSidebar = $('.header--sidebar'),
			menu = $('.menu'),
			checkPoint = 1200,
			windowWidth = $(window).outerWidth();
		var headerTopHeight = $('.header .header__top').outerHeight();
		if (checkPoint > windowWidth) {
			$('.menu').find('.sub-menu').hide();
			menu.find('.menu').addClass('menu--mobile');
			$('.ps-sticky').addClass('desktop');
		} else {
			$('.menu').find('.sub-menu').show();
			header.removeClass('header--mobile');
			menu.removeClass('menu--mobile');
			$('.header--sidebar').removeClass('active');
			$('.ps-main, .header').removeClass('menu--active');
			$('.menu-toggle').removeClass('active');
			$('.ps-sticky').removeClass('desktop');
		}
	}

	function stickyHeader() {
		var header = $('.header'),
		scrollPosition = 0,
		headerTopHeight = $('.header .header__top').outerHeight(),
		checkpoint = 150;
		header.addClass('navigation--sticky');
		$(window).scroll(function() {
			headerTopHeight = $('.header .header__top').outerHeight();
			var currentPosition = $(this).scrollTop();
			if (currentPosition < scrollPosition) {
				if (currentPosition == 0) {
					header.removeClass('navigation--pin');
					header.css("margin-top", 0);
				} else if (currentPosition > checkpoint) {
					header.addClass('navigation--pin');
					header.css("margin-top",0);
				}
			} else {
				if (currentPosition > checkpoint) {
					header.removeClass('navigation--pin');
					header.css("margin-top", -headerTopHeight);
				}
			}
			scrollPosition = currentPosition;
		});
	}

	function mapConfig() {
		var map = $('#contact-map');
		if (map.length > 0) {
			map.gmap3({
				address: map.data('address'),
				zoom: map.data('zoom'),
				scrollwheel: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				styles: [{
					"featureType": "administrative",
					"elementType": "all",
					"stylers": [{
						"visibility": "on"
					}, {
						"lightness": 33
					}]
				}, {
					"featureType": "landscape",
					"elementType": "all",
					"stylers": [{
						"color": "#f2e5d4"
					}]
				}, {
					"featureType": "poi.park",
					"elementType": "geometry",
					"stylers": [{
						"color": "#c5dac6"
					}]
				}, {
					"featureType": "poi.park",
					"elementType": "labels",
					"stylers": [{
						"visibility": "on"
					}, {
						"lightness": 20
					}]
				}, {
					"featureType": "road",
					"elementType": "all",
					"stylers": [{
						"lightness": 20
					}]
				}, {
					"featureType": "road.highway",
					"elementType": "geometry",
					"stylers": [{
						"color": "#c5c6c6"
					}]
				}, {
					"featureType": "road.arterial",
					"elementType": "geometry",
					"stylers": [{
						"color": "#e4d7c6"
					}]
				}, {
					"featureType": "road.local",
					"elementType": "geometry",
					"stylers": [{
						"color": "#fbfaf7"
					}]
				}, {
					"featureType": "water",
					"elementType": "all",
					"stylers": [{
						"visibility": "on"
					}, {
						"color": "#acbcc9"
					}]
				}]
			}).marker(function(map) {
				return {
					position: map.getCenter(),
					icon: 'template/Default/img/marker.png',
				};
			}).infowindow({
				content: map.data('address')
			}).then(function(infowindow) {
				var map = this.get(0);
				var marker = this.get(1);
				infowindow.open(map, marker);
				marker.addListener('click', function() {
					infowindow.open(map, marker);
				});
			});
		}
	}

	function stickyWidget() {
		var widget = $('.ps-sticky.desktop');
		if (widget.length > 0 && $('.ps-sidebar').length > 0) {
			var sidebarEnd = $('.ps-sidebar').offset().top + $('.ps-sidebar').height();
			var stickyHeight = widget.height(),
				sidebarTop = widget.offset().top;
		}
		$(window).scroll(function() {
			if (widget.length > 0) {
				var scrollTop = $(window).scrollTop();
				if (sidebarTop < scrollTop) {
					widget.css('top', scrollTop - sidebarTop + 100);
					if (scrollTop >= sidebarEnd) {
						widget.css('top', sidebarEnd - sidebarTop - 120);
					}
				} else {
					widget.css('top', '0');
				}
			}
		});
	}

	

	function lazyloadimage() {
		$("img.lazy").lazyload({
			effect: "fadeIn"
		});
	}

	function rating() {
		$('.ps-rating').barrating({
			theme: 'fontawesome-stars',
			readonly: true
		});
	}
	
	jQuery(document).ready(function() {
		backgroundImage();
		parallax();
		menuBtnToggle();
		menuBtnToggleOverPlay();
		subMenuToggle();
		//mapConfig();
		stickyHeader();
		rating();
		lazyloadimage();
	});
	jQuery(window).on('load resize', function() {
		resizeHeader()
	});
})(jQuery);
/**BACK TO TOP**/
jQuery('body').append('<div id="back-top" class="back-top"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" aria-label="Back to top"><path d="M16,21L4,8.9c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4l12.7,12.7c0.2,0.2,0.5,0.3,0.7,0.3c0.3,0,0.5-0.1,0.7-0.3l12.7-12.7c0.4-0.4,0.4-1,0-1.4s-1-0.4-1.4,0L16,21z"></path></svg></div>');
jQuery('#back-top').hide();
if (jQuery(this).position.top > 200) {
    jQuery('#back-top').fadeIn();
} else {
    jQuery('#back-top').fadeOut();
}
jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 200) {
        jQuery('#back-top').fadeIn();
    } else {
        jQuery('#back-top').fadeOut();
    }
});
jQuery(window).on( 'load',function() {
    if (jQuery(this).scrollTop() > 200) {
        jQuery('#back-top').fadeIn();
    } else {
        jQuery('#back-top').fadeOut();
    }
});
// scroll body to 0px on click
jQuery('.back-top').click(function() {
    jQuery('body,html').stop(false, false).animate({
        scrollTop: 0
    }, 300);
    return false;
});
/**BACK TO TOP**/
jQuery(document).ready(function(){
	jQuery('#btnsearch').click(function(){
		if(jQuery('#searchform').width()<170){
			jQuery(this).html('<i class="fat fa-xmark btn-close-red" style="color:red;"></i>');
			jQuery(this).addClass('close');
			jQuery(this).parents().find('.header').addClass('search-nav');  
			jQuery('#searchform').addClass('widthFull');
		}else{
			jQuery(this).html('<i class="ps-icon-search"></i>');
			jQuery(this).removeClass('close');
			jQuery(this).parents().find('.header').removeClass('search-nav');
			jQuery('#searchform').removeClass('widthFull');
			jQuery('#suggestions').html('');
			jQuery('#suggestions').hide();
		}
	});
	var mouse_is_inside = false;
	jQuery('#inputString').hover(function(){ 
        mouse_is_inside=true; 
    }, function(){ 
        mouse_is_inside=false; 
    });
	
	
	//////////////Cart Pluss
	$('.add').click(function () {
		if ($(this).prev().val()) {
			$(this).prev().val(+$(this).prev().val() + 1);
		}
	});
	$('.sub').click(function () {
		if ($(this).next().val() > 1) {
			if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
		}
	});
});

function parseOptions(e){
	return "string" == typeof e ? JSON.parse(e.replace(/'/g, '"').replace(";", "").replace(/\s/g, '')) : {}
}
var slider_splide = jQuery('.slider-splide-config');
if(slider_splide.length>0){
	var $parseOptions;
	var elms = document.getElementsByClassName('slider-splide-config');
	for ( var i = 0; i < elms.length; i++ ) {	
		$parseOptions = parseOptions(elms[i].getAttribute("data-options"));
		var slider_splide_config = new Splide(elms[i],$parseOptions);

		slider_splide_config.on('mounted', function () {
			
			 if(slider_splide_config.length<=slider_splide_config.n.perPage){
				jQuery(elms[i]).find('.splide__list').addClass('justify-content-center');
				jQuery(slider_splide_config.Components.Arrows.arrows.prev).hide();
				jQuery(slider_splide_config.Components.Arrows.arrows.next).hide();
			 }
			 if(slider_splide_config.length<2){
				 jQuery(elms[i]).find('.splide__list').addClass('justify-content-center');
				 jQuery(slider_splide_config.Components.Arrows.arrows.prev).hide();
				jQuery(slider_splide_config.Components.Arrows.arrows.next).hide();
			 }
		});
		slider_splide_config.mount();
	}
}

var slider_splide_ex = jQuery('.slider-splide-config-ex');
if(slider_splide_ex.length>0){
	var $parseOptions;
	var elmsex = document.getElementsByClassName('slider-splide-config-ex');
	for ( var i = 0; i < elmsex.length; i++ ) {	
		$parseOptions = parseOptions(elmsex[i].getAttribute("data-options"));
		var slider_splide_config_ex = new Splide( elmsex[i],$parseOptions).mount();
		slider_splide_config_ex.on('mounted', function () {
			
			 if(slider_splide_config_ex.length<=slider_splide_config_ex.n.perPage){
				jQuery(elmsex[i]).find('.splide__list').addClass('justify-content-center');
				jQuery(slider_splide_config_ex.Components.Arrows.arrows.prev).hide();
				jQuery(slider_splide_config_ex.Components.Arrows.arrows.next).hide();
			 }
			 if(slider_splide_config_ex.length<2){
				 jQuery(elmsex[i]).find('.splide__list').addClass('justify-content-center');
				 jQuery(slider_splide_config_ex.Components.Arrows.arrows.prev).hide();
				jQuery(slider_splide_config_ex.Components.Arrows.arrows.next).hide();
			 }
		});
		slider_splide_config_ex.mount(window.splide.Extensions);
	}
}