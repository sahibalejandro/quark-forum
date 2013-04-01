$(document).on('ready', function (e)
{
  // Inicializar tooltips
  $('[data-toggle=tooltip]').tooltip();
});

var QuarkForum = {
  /**
   * Muestra un mensaje en el area de mensajes, el mensaje desaparece automaticamente
   * despues de 8 segundos.
   */
  showMessage: function (message, type)
  {
    // Timeout para desaparecer el mensaje
    var timeout = null;

    /* Botón para remover el mensaje.
     * Cuando se presiona este boton se cancela el timeout y se remueve el mensaje */
    var $Close = $('<a>')
      .addClass('close')
      .attr('href', 'javascript:;')
      .html('&times;')
      .on('click', function (e)
      {
        clearTimeout(timeout);
        QuarkForum.removeMessage($Msg);
      });

    // Contenedor del mensaje, oculto por default.
    var $Msg = $('<div>')
      .addClass('hide alert alert-block ' + (type != undefined ? 'alert-' + type : ''))
      .append($Close, message);

    // Agregar el mensaje a el area de mensajes
    $('#messages-area').append($Msg);

    /* Mostrar el mensaje con un efecto, y cuando sea visible iniciamos
     * el timeout para remover el mensaje */
    $Msg.slideDown('fast', function ()
    {
      timeout = setTimeout(function ()
      {
        QuarkForum.removeMessage($Msg);
      }, 8000);
    });
  },

  /**
   * Remueve un mensaje del area de mensajes
   *
   * @param [jQuery Object] $Message Mensaje a remover
   */
  removeMessage: function($Message)
  {
    $Message.slideUp('fast', function ()
    {
      $(this).remove();
    });
  }
};
