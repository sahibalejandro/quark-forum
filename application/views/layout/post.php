<?php
/**
 * Esta vista es para mostrar la información de un post o comentario.
 */
?>
<div class="post <?php if ($ThePost->isComment()) echo 'comment'; ?>"
  <?php if ($ThePost->isComment()) echo 'id="comment_'.$ThePost->id.'"'?>>
  
  <div class="post-header">
    <?php if (!$ThePost->isComment()): ?>
    <h1><?php echo $this->QuarkStr->esc($ThePost->title); ?></h1>
    <?php endif; ?>

    <div class="post-info">
      {<?php echo $ThePost->id; ?>}
      <?php if ($ThePost->isComment()): ?>
      <i class="icon-comment"></i>
      <?php endif; ?>
      Publicado el <?php echo $this->formatDate($ThePost->creation_date); ?>
      por <?php echo $ThePost->User->getLink(); ?>.
      <?php if ($ThePost->modification_date != null): ?>
      <span class="post-modification-date">
        Última modificación el
        <?php echo $this->formatDate($ThePost->modification_date); ?>
      </span>
      <?php endif; ?>
    </div>
    <!-- // .post-info -->

  </div>
  <!-- // .post-header -->

  <div class="post-content">
    <?php echo $ThePost->getContent(); ?>
  </div>
  <!-- // .post-content -->

  <div class="post-footer">
    <?php
    // Mostrar botones para editar/eliminar si el usuario activo tiene permisos
    if ($this->User->canEditPost($ThePost)): ?>
    <a href="#" data-toggle="tooltip"
      title="Editar <?php echo $ThePost->isComment() ? 'comentario' : 'tema'; ?>">
      <i class="icon-edit"></i>
      Editar
    </a>
    <a href="#" data-toggle="tooltip"
      title="Eliminar <?php echo $ThePost->isComment() ? 'comentario' : 'tema'; ?>">
      <i class="icon-trash"></i>
      Eliminar
    </a>
    <?php endif;
    /* Mostrar botones para observar y agregar a favoritos solo cuando $ThePost
     * no es un comentario. */
    if (!$ThePost->isComment()): ?>
    <a href="#" data-toggle="tooltip" title="<?php
        echo $this->User->isWatchingPost($ThePost)
          ? 'Dejar de observar el tema.' : 'Observar el tema';
      ?>"><i class="icon-<?php
        echo $this->User->isWatchingPost($ThePost)
          ? 'eye-close' : 'eye-open';
      ?>"></i>
      <?php echo number_format($ThePost->getWatchedCount()); ?>
    </a>

    <a href="#" data-toggle="tooltip" title="<?php
        echo $this->User->isFavoritePost($ThePost)
          ? 'Eliminar de favoritos.' : 'Agregar a favoritos';
      ?>"><i class="icon-<?php
        echo $this->User->isFavoritePost($ThePost)
          ? 'star' : 'star-empty';
      ?>"></i>
      <?php echo number_format($ThePost->getFavoriteCount()); ?>
    </a>
    <?php endif; ?>

    <a href="#" data-toggle="tooltip" title="Marcar punto bueno">
      <i class="icon-thumbs-up"></i>
      <?php echo number_format($ThePost->good_points); ?>
    </a>

    <a href="#" data-toggle="tooltip" title="Marcar punto malo">
      <i class="icon-thumbs-down"></i>
      <?php echo number_format($ThePost->bad_points); ?>
    </a>

    <a href="<?php echo $ThePost->getURL(); ?>"
      data-toggle="tooltip"
      title="Enlace permanente">
      <i class="icon-magnet"></i>
      Permalink
    </a>
  </div>
  <!-- // .post-footer -->

</div>
<!-- // .post -->
