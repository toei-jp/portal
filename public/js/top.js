$(function () {
    var screeningWorkSlider = createScreeningWorkSlider();
    var scheduledWorkSlider = createScheduledWorkSlider();
    changeSliderArrowTop();
});
$(window).on('resize', changeSliderArrowTop);
/**
 * スライダーの矢印のtopを変更
 */
function changeSliderArrowTop() {
    // 上映中
    var height = $('.now-showing .image').css('padding-top');
    var top = parseInt(height, 10) / 2;
    $('.now-showing .swiper-button-next, .now-showing .swiper-button-prev').css('top', top);
    // 上映予定
    var height = $('.coming-soon .image').css('padding-top');
    var top = parseInt(height, 10) / 2;
    $('.coming-soon .swiper-button-next, .coming-soon .swiper-button-prev').css('top', top);
}

/**
 * 上映中作品スライダー作成
 */
function createScreeningWorkSlider() {
    var options = {
        speed: 500,
        spaceBetween: 10,
        slidesPerView: 4,
        navigation: {
            nextEl: '.screening-work .swiper-button-next',
            prevEl: '.screening-work .swiper-button-prev',
        },
        breakpoints: {
            767: {
                spaceBetween: 0,
                slidesPerView: 2.2
            }
        }
    };
    return new Swiper('.screening-work .swiper-container', options);
}

/**
 * 上映予定作品スライダー作成
 */
function createScheduledWorkSlider() {
    var options = {
        speed: 500,
        spaceBetween: 10,
        slidesPerView: 4,
        navigation: {
            nextEl: '.scheduled-work .swiper-button-next',
            prevEl: '.scheduled-work .swiper-button-prev',
        },
        breakpoints: {
            767: {
                spaceBetween: 0,
                slidesPerView: 2.2
            }
        }
    };
    return new Swiper('.scheduled-work .swiper-container', options);
}