$('button').click(() => {
    $('aside').addClass('open');
    $('#overlay').addClass('open');
})

$('#overlay').click(() => {
    $('aside').removeClass('open');
    $('#overlay').removeClass('open');
})