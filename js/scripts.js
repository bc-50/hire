$(function () {
  var $hamburger = $('.hamburger');
  $hamburger.on('click', function (e) {
    $hamburger.toggleClass('is-active');
    // Do something else, like open/close menu
  });

  $('.question').click(function (e) {
    e.preventDefault();
    if ($(e.target).hasClass('question')) {
      var target = $(e.target);
    } else {
      var target = $(e.target).parents('.question');
    }
    var ans = $(target).next('.answer');

    $('.answer').each(function (e) {
      if ($(this).hasClass('show')) {
        $(this).removeClass('show');
      }
    });

    $(ans).addClass('show');

    console.log(e.target);
    console.log($(ans));
  });


});