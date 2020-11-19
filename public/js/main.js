equalheight = function (container) {
  var currentTallest = 0,
    currentRowStart = 0,
    rowDivs = new Array(),
    $el,
    topPosition = 0;
  $(container).each(function () {
    $el = $(this);
    $($el).outerHeight("auto");
    topPostion = $el.position().top;

    if (currentRowStart != topPostion) {
      for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
        rowDivs[currentDiv].outerHeight(currentTallest);
      }
      rowDivs.length = 0; // empty the array
      currentRowStart = topPostion;
      currentTallest = $el.outerHeight();
      rowDivs.push($el);
    } else {
      rowDivs.push($el);
      currentTallest =
        currentTallest < $el.outerHeight() ? $el.outerHeight() : currentTallest;
    }
    for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
      rowDivs[currentDiv].outerHeight(currentTallest);
    }
  });
};

function allEqualHeight() {
  //equalheight('.image-box--description');
}

function LoadingBar() {
  this.wrapper = null;
  this.bar = null;
  this.percentage = 0;

  this.create = function (wrapper) {
    var $wrapper = $(wrapper);

    $wrapper.append(this._template());

    this.wrapper = $(".loadingbar");
    this.bar = this.wrapper.children(".bar");
    this.percentage = 0;

    this.bar.css({ width: this.percentage });
  };

  this.inc = function () {
    this.percentage++;

    return this;
  };

  this.set = function (percentage) {
    percentage = parseInt(percentage);
    if (percentage >= 0 && percentage <= 100) {
      this.percentage = percentage;
    }

    return this;
  };

  this.update = function () {
    var percent = this.percentage + "%";

    this.bar.css({ width: percent });

    return this;
  };

  this.hide = function () {
    var wrapper = this.wrapper;

    setTimeout(function () {
      wrapper.addClass("loadingbar--hide");
    }, 300);

    setTimeout(function () {
      wrapper.css({ display: "none" });
    }, 800);
  };

  this._template = function () {
    return '<div class="loadingbar"><div class="bar"></div></div>';
  };
}

function loadingpage() {
  document.addEventListener("DOMContentLoaded", progresspage, false);

  function progresspage() {
    var loader = new LoadingBar();
    loader.create("body");

    var img = document.images,
      c = 0,
      tot = img.length;

    if (tot == 0) return doneLoading();

    function imgLoaded() {
      c += 1;
      var perc = ((100 / tot) * c) << 0;
      loader.set(perc).update();

      if (c === tot) return doneLoading();
    }

    function doneLoading() {
      loader.hide();
    }

    for (var i = 0; i < tot; i++) {
      var tImg = new Image();
      tImg.onload = imgLoaded;
      tImg.onerror = imgLoaded;
      tImg.src = img[i].src;
    }
  }
}

/* Manage Scroll header */
function checkScroll() {
  if ($(document).scrollTop() > 150) {
    $(".header").addClass("visible");
  } else {
    $(".header").removeClass("visible");
  }
}

/* Check if iOS device */
function iOS() {
  return [
    'iPad Simulator',
    'iPhone Simulator',
    'iPod Simulator',
    'iPad',
    'iPhone',
    'iPod'
  ].includes(navigator.platform)
  // iPad on iOS 13 detection
  || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
}

$(document).ready(function () {
  "use strict";

  new WOW().init();

  // If is mobile, add class for visible layer on sections' blocks
  if (
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    $(".page.page--home .page__block--sections .block.block--layer").each(
      function () {
        $(this).addClass("visible");
      }
    );
  }

  if (iOS() == true){
    $(".page__header .page__header__background").addClass("page__header__background--ios");
  }

  /*
   * Smooth Scroll on Pageload
   * Smooth scrolling on page load if URL have a hash
   * Author: Franco Moya - @iamravenous
   */
  if (window.location.hash) {
    var hash = window.location.hash;

    $("html, body").animate(
      {
        scrollTop: $(hash).offset().top - 100,
      },
      1500,
      "swing"
    );
  }

  // Click on submit button -> submit form
  $("button#form-submit").on("click", function (e) {
    var form_data = $("#contact-form").serializeArray();
    var error_free = true;
    for (var input in form_data) {
      var element = $("#contact_" + form_data[input]["name"]);
      var valid = element.hasClass("valid");
      var error_element = $("span", element.parent());
      if (!valid && element.selector != "#contact_g-recaptcha-response") {
        error_element.removeClass("error").addClass("error_show");
        error_free = false;
      } else {
        error_element.removeClass("error_show").addClass("error");
      }
    }
    if (!error_free) {
      event.preventDefault();
    } else {
      var recaptcha = $("#g-recaptcha-response").val();
      if (recaptcha === "") {
        event.preventDefault();
        alert("Please check the recaptcha");
      }
      else{
        $("form#contact-form").submit();
      }
    }
  });

  // Check name input data
  $("#contact_name").on("input", function () {
    var input = $(this);
    var is_name = input.val();
    if (is_name) {
      input.removeClass("invalid").addClass("valid");
    } else {
      input.removeClass("valid").addClass("invalid");
    }
  });

  // Check surname input data
  $("#contact_surname").on("input", function () {
    var input = $(this);
    var is_surname = input.val();
    if (is_surname) {
      input.removeClass("invalid").addClass("valid");
    } else {
      input.removeClass("valid").addClass("invalid");
    }
  });

  // Check phone input data
  $("#contact_phone").on("input", function () {
    var input = $(this);
    var is_phone = input.val();
    var intRegex = /[0-9 -()+]+$/;
    if (is_phone.length < 10 || !intRegex.test(is_phone)) {
      is_phone = false;
    }
    if (is_phone) {
      input.removeClass("invalid").addClass("valid");
    } else {
      input.removeClass("valid").addClass("invalid");
    }
  });

  // Check message input data
  $("#contact_message").on("input", function () {
    var input = $(this);
    var is_message = input.val();
    if (is_message) {
      input.removeClass("invalid").addClass("valid");
    } else {
      input.removeClass("valid").addClass("invalid");
    }
  });

  // Check Email input data
  $("#contact_email").on("input", function () {
    var input = $(this);
    var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var is_email = re.test(input.val());
    if (is_email) {
      input.removeClass("invalid").addClass("valid");
    } else {
      input.removeClass("valid").addClass("invalid");
    }
  });

  $(".hamburger").on("click", function () {
    $(this).toggleClass("is-active");
    $(this).toggleClass("hamburger--squeeze");
    if ($(this).hasClass("is-active")) {
      //$(".menu.menu--mobile").fadeIn(700);
      $(".menu.menu--mobile").addClass("visible");
      $(".header").addClass("visible");
      $("body").addClass("overflow");
    } else {
      $(".menu.menu--mobile").removeClass("visible");
      checkScroll();
      $("body").removeClass("overflow");
    }
  });

  /* SMOOTH SCROLL-TO-ELEMENT */
  $('a[href^="#"]').on("click", function (event) {
    var target = $(this.getAttribute("href"));
    if (target.length) {
      event.preventDefault();
      $("html, body").stop().animate(
        {
          scrollTop: target.offset().top,
        },
        1000
      );
    }
  });
});

window.onload = function () {
  allEqualHeight();
  checkScroll();
};

$(window).resize(function () {
  allEqualHeight();
  //checkScroll();
});

$(window).scroll(function () {
  checkScroll();
});

$(window).load(function () {
  $("#page-preload").fadeOut(500);
});

/* GOOLE MAPS */

/* function initMap(map_elem) {
    var $map = map_elem;
    var lat = $map.data("lat");
    var lng = $map.data("lng");
    var zoom = $map.data("zoom");
    if ($map.length && lat!='' && lng!='') {
        
        var infowindow = null,
                icon = new google.maps.MarkerImage("/i/markers/default.png", null, null, new google.maps.Point(21, 27), new google.maps.Size(42, 57)),

        var myOptions = {
            zoom: zoom,
            scrollwheel: false,
            streetViewControl: false,
            draggable: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            styles: [{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"poi.attraction","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.government","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"poi.medical","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"poi.place_of_worship","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}]
        };

        var map = new google.maps.Map($map[0], myOptions);
        AutoCenter(map);

        setMarkers(map, sites);
        infowindow = new google.maps.InfoWindow({
            content: "loading..."
        });

        var producer_count = 0;
        var market_count = 0;
        var rete_count = 0;

        function setMarkers(map, markers) {

            for (var i = 0; i < markers.length; i++) {
                var site = markers[i];
                var siteLatLng = new google.maps.LatLng(site.lat, site.lng);

                var image = new google.maps.MarkerImage("/i/markers/default.png", null, null, new google.maps.Point(21,57), new google.maps.Size(42, 57));

                var marker = new google.maps.Marker({
                    icon: image,
                    position: siteLatLng,
                    map: map,
                    title: site.title,
                    zIndex: site.zIndex,
                    html: site.html
                });

                google.maps.event.addListener(marker, "click", function () {
                });
            }
        }


        function AutoCenter(map) {
            //  Create a new viewpoint bound
            var bounds = new google.maps.LatLngBounds();
            //  Go through each...
            $.each(sites, function (index, marker) {
                var marker_position = new google.maps.LatLng(marker.lat, marker.lng);
                bounds.extend(marker_position);
            });
            //  Fit these bounds to the map
            //console.debug(sites.length);
            if (sites.length > 1) {
                map.fitBounds(bounds);
            } else {
                centro = new google.maps.LatLng(sites[0].lat, sites[0].lng);
                map.setCenter(centro);
                map.setZoom(zoom);
            }
        }

    }
}*/

/* SCROLL PARALLAX */
/*$.fn.moveIt = function(){
    var $window = $(window);
    var instances = [];

    $(this).each(function(){
      instances.push(new moveItItem($(this)));
    });

    window.onscroll = function(){
      var scrollTop = $window.scrollTop();
      instances.forEach(function(inst){
        inst.update(scrollTop);
      });
    };
};

var moveItItem = function(el){
  this.el = $(el);
  this.speed = parseInt(this.el.attr('data-scroll-speed'));
};

moveItItem.prototype.update = function(scrollTop){
    if($(window).width()>=970){
        
        var container = this.el.parents('.parallax-row');
        var elHeight = this.el.height();
        var postop = parseInt(container.offset().top - $(window).scrollTop());
        
        if(postop <= $(window).height()){
            postop = elHeight + (postop * (-1));
            if(this.el.data("scroll-direction") == "down"){
                this.el.css('transform', 'translateY(' + +(postop / this.speed) + 'px)');
            }else{
                this.el.css('transform', 'translateY(' + -(postop / this.speed) + 'px)');
            }
        }
    }else{
        this.el.css('transform', 'translateY(0px)');
    }
};

$(function(){
  $('[data-scroll-speed]').moveIt();
});*/
