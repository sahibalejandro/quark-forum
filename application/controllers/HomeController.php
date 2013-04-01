<?php
class HomeController extends ForumController
{
  public function __construct()
  {
    parent::__construct();
    
    $this->setActionsAccessLevel(array(
      'ajaxPostComment'   => 1,
      'ajaxUpdateComment' => 1,
    ));
  }
  /**
   * Mostrar la lista de categorias principales
   */
  public function index()
  {
    $top_categories = Category::query()
      ->select()
      ->where(array('categories_id' => null))
      ->orderBy('name')
      ->exec();

    $this->renderView(null, array('top_categories' => $top_categories));
  }

  public function category($id = null, $page = null)
  {
    // Normalizar $page, no puede ser menor a 1 (uno)
    $page = (int)$page;
    if ($page == 0) $page = 1;

    $Category = Category::query()->selectById($id);

    if ($Category == null) {
      $this->__quarkNotFound();
    } else {
      $this->renderView(null, array('Category' => $Category, 'page' => $page));
    }
  }

  public function post($id = null, $page = null)
  {
    // Normalizar $page, no puede ser menor a 1 (uno)
    $page = (int)$page;
    if ($page == 0) $page = 1;

    $Post = Post::query()
      ->join('User')
      ->selectById($id);

    if ($Post == null) {
      $this->__quarkNotFound();
    } else {
      /* ID del comentario al que se hara scroll cuando la pagina termina de cargar
       * esto solo es necesario cuando el $id corresponde a un Post que es un
       * comentario de otro Post */
      $scroll_comment_id = null;

      /* Si el post existe, pero es un comentario, obtenemos el Post original
       * y buscamos en que pagina se encuentra el comentario, además activamos la
       * variable $scroll_comment_id para que la pagina haga scroll hasta el
       * comentario deseado */
      if ($Post != null && $Post->posts_id != null) {
        $Post = Post::query()->join('User')->selectById($Post->posts_id);
        $page = Post::findCommentPage($Post->id, $id);
        $scroll_comment_id = $id;
      }

      $this->renderView(null, array(
        'Post'               => $Post,
        'page'               => $page,
        'scroll_comment_id'  => $scroll_comment_id,
      ));
    }
  }
}
