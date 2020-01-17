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
  });

  function load_pack(id) {
    var data = {
      action: "change_pack_ajax",
      pid: id,
    };

    $.ajax({
      type: "POST",
      dataType: "html",
      url: ajax_posts.ajaxurl,
      data: data,
      success: function (data) {
        var $data = $(data);
        $("#package-info").html('');
        $("#package-info").append($data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(
          jqXHR.getAllResponseHeaders() +
          " :: " +
          textStatus +
          " :: " +
          errorThrown
        );
      }
    });
    return false;
  }

  $('.pack-choice').click(function (e) {
    if ($(e.target).hasClass('pack-choice')) {
      var target = $(e.target);
    } else {
      var target = $(e.target).parents('.pack-choice');
    }
    load_pack($(target).data('id'));
  });
});