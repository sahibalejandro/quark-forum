<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Tema</th>
      <th>Comentarios</th>
      <th>Fecha</th>
      <th>Último comentario</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($posts as $Post):
    $comments_count = $Post->getCommentsCount();
    ?>
    <tr>
      <td class="cell-centered">
        <?php
        if ($this->User->isFavoritePost($Post)):
        ?>
        <i class="icon-star" title="Es uno de tus favoritos."></i>
        <?php
        elseif ($this->User->isWatchingPost($Post)):
        ?>
        <i class="icon-eye-open" title="Estas observando este tema."></i>
        <?php
        elseif ($Post->isGlobal()):
        ?>
        <i class="icon-bullhorn" title="Tema global."></i>
        <?php
        elseif ($comments_count >= 20):
        ?>
        <i class="icon-fire" title="Tema con muchos comentarios."></i>
        <?php
        elseif ($Post->sticky == 1):
        ?>
        <i class="icon-flag" title="Tema importante."></i>
        <?php
        endif;
        ?>
      </td>
      <td>
        <a href="<?php echo $Post->getURL(); ?>"><?php echo $this->QuarkStr->esc($Post->title); ?></a>
        <div class="post-info">
          Por <?php echo $Post->User->getLink(); ?>
        </div>
      </td>
      <td class="cell-centered"><?php echo number_format($comments_count); ?></td>
      <td class="cell-centered"><span class="post-date-small"><?php echo $this->formatDate($Post->creation_date); ?></span></td>
      <td><?php $this->renderLastPost($Post->getLastComment()); ?>
      </td>
    </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>
