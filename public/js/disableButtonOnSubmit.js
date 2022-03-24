  // disable submit button on submit
$('form').submit(function() {
    $(this).find('button[type=submit]').attr('disabled', true);
});
  //  enable submit button on change
$('input').on('keydown', function() {
    $('button[type=submit]').removeAttr('disabled');
});
$('input').on('change', function() {
    $('button[type=submit]').removeAttr('disabled');
});
$('select').on('change', function() {
    $('button[type=submit]').removeAttr('disabled');
});
$('textarea').on('keydown', function() {
    $('button[type=submit]').removeAttr('disabled');
});
