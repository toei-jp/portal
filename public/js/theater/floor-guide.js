$(document).on('click', '.thumbnail a', function(event){
    event.preventDefault();
    var src = $(this).parents('.thumbnail').find('.screen-image').attr('src');
    console.log(src)
    $('#screenModal .screen-image').attr('src', src);
    $('#screenModal').modal('show');
});