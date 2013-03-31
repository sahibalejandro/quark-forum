<?php
$last_item = array_pop($items);
?>
<ul id="breadcrumbs" class="breadcrumb">
  <li><a href="<?php
    echo $this->QuarkURL->getBaseURL();
  ?>">Inicio</a><span class="divider">/</span></li><?php
  foreach ($items as $item):
  ?><li><a href="<?php echo $item['url'] ?>"><?php
    echo $this->QuarkStr->esc($item['text']);
  ?></a><span class="divider">/</span></li><?php
  endforeach;
  ?><li class="active"><?php echo $last_item['text'] ?></li>
</ul>
