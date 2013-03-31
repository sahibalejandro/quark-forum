$(document).on('ready', function (e)
{
  var $BtnSubmit      = $('#btn_post_comment');
  var btn_submit_html = $BtnSubmit.html();

  $('#frm_comment').on('submit', function (e)
  {
    Quark.ajax('home/ajax-post-comment', {
      data: $(this).serialize(),
      beforeSend: function ()
      {
        $BtnSubmit.html('Publicando...').attr('disabled', 'disabled');
      },
      success: function (Response)
      {
        QuarkForum.showMessage(
          'Tu comentario ha sido publicado, has' +
          ' <a href="'+Response.result+'">click aquí</a> para verlo.',
          'success'
        );
      },
      fail: function (Response) {
        QuarkForum.showMessage(Response.message, 'error');
      },
      complete: function ()
      {
        $BtnSubmit.html(btn_submit_html).removeAttr('disabled');
      }
    });
  });
});
