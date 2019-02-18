$(document).on('click', '.question a', function (event) {
    event.preventDefault();
    if ($(this).parents('.question').hasClass('open')) {
        // 開いてるとき
        $(this).parents('.question').removeClass('open');
        $(this).parents('li').find('.answer').addClass('d-none');
    } else {
        // 閉じてるとき
        $(this).parents('.question').addClass('open');
        $(this).parents('li').find('.answer').removeClass('d-none');
    }
});

