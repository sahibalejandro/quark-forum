$(document).on('ready', function (e)
{
  if (typeof SCROLL_COMMENT_ID != 'undefined') {
    var $CommentElement = $('#comment_' + SCROLL_COMMENT_ID);
    $('html').animate({
      scrollTop: $CommentElement.offset().top + 'px'
    }, 1000);
  }
});
