<?php
$this->header();
$this->renderBreadcrumbs($Category);
?>
<div class="page-header">
  <h4><?php echo $this->QuarkStr->esc($Category->name); ?></h4>
  <p><?php echo $this->QuarkStr->esc($Category->description); ?></p>
</div>
<?php
if ($Category->hasSubCategories()):
  $this->renderCategoryList($Category);
endif;

/* Se pueden publicar posts solo en las categorías que NO son top-category
 * es decir que el campo 'categories_id' no sea NULL */
if ($Category->categories_id != null):
?>
<div class="btn-toolbar">
  <a href="#" class="btn">
    <i class="icon-plus"></i>
    Nuevo tema
  </a>
</div>
<?php
endif;

// Mostrar la lista de posts en esta categoría
$this->renderCategoryPostsList($Category, $page);
$this->footer();
