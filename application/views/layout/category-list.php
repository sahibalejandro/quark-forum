<table class="table table-bordered table-striped categories-list">
  <thead>
    <tr>
      <th class="col-category"><?php echo $this->QuarkStr->esc($TopCategory->name); ?></th>
      <th class="col-post-count">Temas</th>
      <th>Último tema</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($TopCategory->getChilds('Category')->exec() as $Category):
    ?>
    <tr>
      <td>
        <a href="<?php echo $Category->getURL(); ?>">
          <?php echo $this->QuarkStr->esc($Category->name); ?>
        </a>
        <p><?php echo $this->QuarkStr->esc($Category->description); ?></p>
      </td>
      <td class="cell-centered"><?php echo number_format($Category->getPostsCount()); ?></td>
      <td>
        <?php $this->renderLastPost($Category->getLastPost()); ?>
      </td>
    </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>
