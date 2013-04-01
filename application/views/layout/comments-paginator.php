<?php if ($pages_count > 1): ?>
  <div class="pagination pagination-right">
    <ul>
      <li class="disabled"><span>Páginas:</span></li>
      <li><a href="<?php echo $post_url; ?>#comments">&larr;</a></li>
      <?php for ($page = 1; $page <= $pages_count; $page++):
      if ($page == $actual_page): ?>
      <li class="active"><span><?php echo $page; ?></span></li>
      <?php else: ?>
      <li><a href="<?php echo $post_url.'/'.$page; ?>#comments"><?php echo $page; ?></a></li>
      <?php
      endif;
      endfor; ?>
      <li><a href="<?php echo $post_url.'/'.$pages_count; ?>#comments">&rarr;</a></li>
    </ul>
  </div>
<?php endif; ?>
