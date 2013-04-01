$(document).on('ready', function (e)
{
  if (typeof SCROLL_COMMENT_ID != 'undefined') {
    var $CommentElement = $('#comment_' + SCROLL_COMMENT_ID);
    $CommentElement.addClass('active');

    $('html').animate({
      scrollTop: $CommentElement.offset().top + 'px'
    }, 1000);
  }

  /**
   * Mostrar el formulario para editar un comentario
   */
  $('a[data-edit-comment]').on('click', function (e)
  {
  });
});
