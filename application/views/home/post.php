<?php
$this->appendJsFiles('post.js');
$this->header();
$this->renderBreadcrumbs($Post);
$this->renderPost($Post);
?><a name="comments"></a><?php
$this->renderPostCommentsPage($Post, $page);
$this->renderCommentsPaginator($Post, $page);

/**
 * Mostrar el botón para inciar sesión si el usuario no esta firmado, cuando este
 * firmado podra ver el formulario.
 */
if (!$this->userAreSigned()):
  $this->renderLoginButton();
else:
  ?>
  <button id="btn_post_comment" type="button" class="btn btn-large">
    <i class="icon-pencil"></i>
    Escribir comentario
  </button>
  <?php
endif;
// END OF: if (!$this->userAreSigned())

/* Crear el flag para JavaScript para que la pagina haga scroll hasta un comentario
 * en especifico */
if ($scroll_comment_id != null):
?>
<script>
  var SCROLL_COMMENT_ID = <?php echo $scroll_comment_id; ?>;
</script>
<?php endif; ?>
<!-- // Area para escribir un comentario -->

<?php $this->footer();
