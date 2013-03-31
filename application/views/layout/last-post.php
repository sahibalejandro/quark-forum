<div class="last-post">
  <?php if ($LastPost == null): ?>
  - - -
  <?php else:
  if ($LastPost->posts_id == null):
  ?>
  <div>
    <strong><?php echo $this->QuarkStr->esc($this->QuarkStr->resumeText($LastPost->title, 8)); ?></strong>
  </div>
  <?php
  endif;
  ?>
  <div>
    Por <?php echo $LastPost->User->getLink(); ?>
  </div>
  <div>
    El <?php echo $this->formatDate($LastPost->creation_date); ?>
    <a href="<?php echo $LastPost->getURL(); ?>">Leer &raquo;</a>
  </div>
  <?php endif; ?>
</div>
