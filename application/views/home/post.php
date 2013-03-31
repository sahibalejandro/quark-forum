<?php
$this->appendJsFiles('post.js');
$this->header();
$this->renderBreadcrumbs($Post);
?>
<div class="post">
  <div class="page-header">
    <h3><?php echo $this->QuarkStr->esc($Post->title); ?></h3>
    <div class="post-info">
      Por <?php echo $Post->User->getLink(); ?>,
      el <?php echo $this->formatDate($Post->creation_date); ?>
    </div>
  </div>
  <div class="post-content"><?php echo $Post->content; ?></div>
  <div class="post-buttons">
    <?php if (!$this->User->isWatchingPost($Post)): ?>
    <a href="#" title="Observar este tema.">
      <i class="icon-eye-open"></i>
    </a>
    <?php echo number_format($Post->getWatchedCount()); ?>
    <?php else: ?>
    <a href="#" title="Dejar de observar este tema.">
      <i class="icon-eye-close"></i>
    </a>
    <?php echo number_format($Post->getWatchedCount()); ?>
    <?php endif;
    if (!$this->User->isFavoritePost($Post)): ?>
    <a href="#" title="Agregar a mis favoritos.">
      <i class="icon-star-empty"></i>
    </a>
    <?php echo number_format($Post->getFavoriteCount()); ?>
    <?php else: ?>
    <a href="#" title="Remover de mis favoritos.">
      <i class="icon-star"></i>
    </a>
    <?php echo number_format($Post->getFavoriteCount()); ?>
    <?php endif; ?>
    <a href="#" title="Marcar como bueno.">
      <i class="icon-thumbs-up"></i>
    </a>
    <?php echo number_format($Post->good_points); ?>
    <a href="#" title="Marcar como malo.">
      <i class="icon-thumbs-down"></i>
    </a>
    <?php echo number_format($Post->bad_points); ?>
  </div>
  <!-- // .post-buttons -->
</div>
<!-- // .post -->

<!-- Comentarios -->
<a name="comments"></a>
<div class="post-comments">
  <?php foreach ($Post->getCommentsPage($page) as $Comment): ?>
  <div class="post-comment <?php
    if ($Comment->id == $scroll_comment_id):
      echo 'post-comment-target';
    endif;
    ?>" id="comment_<?php echo $Comment->id; ?>">
    <a name="comment_<?php echo $Comment->id; ?>"></a>
    <div class="post-comment-info">
      <i class="icon-comment"></i>
      Por <?php echo $Comment->User->getLink(); ?>,
      el <?php echo $this->formatDate($Comment->creation_date); ?>:
    </div>
    <div class="post-comment-content">
      <?php echo $Comment->content; ?>
    </div>
    <div class="post-comment-buttons">
      <a href="#" title="Marcar como bueno.">
        <i class="icon-thumbs-up"></i>
      </a>
      <?php echo number_format($Comment->good_points); ?>
      <a href="#" title="Marcar como malo.">
        <i class="icon-thumbs-down"></i>
      </a>
      <?php echo number_format($Comment->bad_points); ?>
    </div>
  </div>
  <!-- // .post-comment -->
  <?php endforeach;
  $this->renderCommentsPaginator($Post, $page);
  ?>
</div>
<!-- // Comentarios -->

<!-- Area para escribir un comentario -->
<h4>Escribe un comentario:</h4>
<?php
/**
 * Mostrar el botón para inciar sesión si el usuario no esta firmado, cuando este
 * firmado podra ver el formulario.
 */
if (!$this->userAreSigned()):
  $this->renderLoginButton();
else:
  // Necesitaremos post-comment.js para publicar el comentario
  $this->appendJsFiles('post-comment.js');
?>
<form action="javascript:;" id="frm_comment">
  <input type="hidden" name="token" value="<?php echo $post_comment_token; ?>" readonly="readonly">
  <textarea name="comment" id="comment" class="span12" rows="5"></textarea>
  <div class="form-actions">
    <button type="submit" id="btn_post_comment" class="btn btn-primary">
      <i class="icon-ok icon-white"></i>
      Publicar
    </button>
  </div>
</form>
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
