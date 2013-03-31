<?php
class HomeController extends ForumController
{
  public function __construct()
  {
    parent::__construct();
    
    $this->setActionsAccessLevel(array(
      'ajaxPostComment' => 1,
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
        // Token para publicar comentario en el Post correcto.
        'post_comment_token' => $this->generatePostCommentToken($Post),
      ));
    }
  }

  /**
   * Guarda un nuevo comentario de un Post en la base de datos, el Post se obtiene
   * mediante $_POST['token'] y ForumController::checkPostCommentToken(), si el token
   * no es valido devuelve un mensaje de error.
   */
  public function ajaxPostComment()
  {
    /* Obtener el ID del Post en base al token, si no existe no se puede publicar el
     * comentario */
    $post_id = $this->checkPostCommentToken($_POST['token']);
    if ($post_id == null) {
      $this->setAjaxResponse(null, 'Token invalido, recarga la pagina e intenta de nuevo.', true);
    } else {
      try {
        /* Verificamos que el Post todavía exista, si no existe no podemos publicar
         * el comentario */
        $count = Post::query()->count()->where(array('id' => $post_id))->exec();
        if ($count == 0) {
          $this->setAjaxResponse(null, 'El tema ya no existe.', true);
        } else {
          $PostComment           = new Post();
          $PostComment->posts_id = $post_id;
          $PostComment->users_id = $this->User->id;
          $PostComment->content  = $_POST['comment'];
          
          if (!$PostComment->save()) {
            $this->setAjaxResponse(null, $PostComment->getErrorMsg(), true);
          } else {
            // Devolvemos el URL del nuevo comentario al cliente.
            $this->setAjaxResponse($PostComment->getURL());
          }
        }
      } catch (QuarkDBException $e) {
        $this->setAjaxResponse(
          null,
          'No se pudo completar la solicitud, intenta más tarde.',
          true
        );
      }
    }
  }
}
