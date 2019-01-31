$(document).on('click','.open-button a',function(event){
    event.preventDefault();
    $(this).parents('.open-button').addClass('d-none');
    $(this).parents('.item').find('.close-button').removeClass('d-none');
    $(this).parents('.item').find('.sp-info').removeClass('d-none');
});
$(document).on('click','.close-button a',function(event){
    event.preventDefault();
    $(this).parents('.close-button').addClass('d-none');
    $(this).parents('.item').find('.open-button').removeClass('d-none');
    $(this).parents('.item').find('.sp-info').addClass('d-none');
});