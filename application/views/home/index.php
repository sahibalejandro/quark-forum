<?php
$this->header();
?>
<div class="page-header">
  <h3>Quark PHP: Foro oficial.</h3>
  <p>Prengunta, responde, reporta bugs, comparte tips, etc. sientete libre de participar, el conocimiento es poder.</p>
</div>
<?php
foreach ($top_categories as $TopCategory):
  $this->renderCategoryList($TopCategory);
endforeach;
$this->footer();
