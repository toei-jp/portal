(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
moment.tz.setDefault('Asia/Tokyo');
$(function () {
    createSubHeaderSlider();
    var mainSlider = createMainSlider();
});

$(document).on('click', 'a[data-scroll-target]', scrollPageLink);
$(document).on('click', '.sp-menu-button a', function (event) {
    event.preventDefault();
    if (!$('.sp-menu').hasClass('d-none')) {
        // メニューを閉じる
        $('.menu-close').addClass('d-none');
        $('.menu').removeClass('d-none');
        $('.sp-menu').addClass('d-none');
    } else {
        // メニューを開く
        $('.menu').addClass('d-none');
        $('.menu-close').removeClass('d-none');
        $('.sp-menu').removeClass('d-none');
    }
});



/**
 * サブヘッダー作成
 */
function createSubHeaderSlider() {
    var options = {
        spaceBetween: 0,
        freeMode: true,
        slidesPerView: 2.5
    };
    return new Swiper('.sub-header .swiper-container', options);
}

/**
 * メインスライダー作成
 */
function createMainSlider() {
    var options = {
        speed: 500,
        spaceBetween: 0,
        loop: true,
        centeredSlides: true,
        loopedSlides: 3,
        controller: false,
        autoplay: {
            delay: 2300,
            disableOnInteraction: false
        },
        navigation: {
            nextEl: '.main-slider .swiper-button-next',
            prevEl: '.main-slider .swiper-button-prev',
        },
        pagination: {
            el: '.main-slider .swiper-pagination',
        }
    };
    return new Swiper('.main-slider .swiper-container', options);
}

/**
 * ページリンクスクロール処理
 * @param {Event} event
 */
function scrollPageLink(event) {
    event.preventDefault();
    var targetSelecter = $(this).attr('data-scroll-target');
    var top = $(targetSelecter).offset().top - $('header').height() - 20;
    $('body, html').animate({ scrollTop: top }, 500);
}

/**
 * スマホ判定
 */
function isMobile() {
    return ($(window).width() < 768);
}
},{}]},{},[1])