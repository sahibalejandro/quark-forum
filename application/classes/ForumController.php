<?php
class ForumController extends QuarkController
{
  protected $User;

  public function __construct()
  {
    parent::__construct();

    /**
     * TODO:
     * Validar la sesión y obtener datos del usuario firmado
     */
    $this->QuarkSess->setAccessLevel(1);
    //$this->User = new User();
    $this->User = User::query()->selectById(1);
  }

  public function renderPost(Post $Post)
  {
    // Enviar $Post con un nombre de variable unico para evitar colisiones.
    $this->renderView('layout/post.php', array('ThePost' => $Post));
  }

  public function renderPostCommentsPage(Post $Post, $page)
  {
    foreach ($Post->getCommentsPage($page) as $Comment) {
      $this->renderPost($Comment);
    }
  }

  /**
   * Envía al buffer el código HTML para mostrar las opciones de formato que pueden
   * ser elegidas para publicar un post/comentario
   * 
   * @param string $default_option Opcion seleccionada por default
   */
  public function renderFormatOptions($default_option = null)
  {
    if ($default_option == null) {
      $default_option = 'txt';
    }

    $this->renderView('layout/post-format-options.php', array(
      'default_option' => $default_option,
    ));
  }

  /**
   * Envía al buffer el código HTML para mostrar los "breadcrumbs" de navegación
   * ya se para para un Post o una Category
   * 
   * @param mixed $Entity Instancia de Post o Category
   */
  public function renderBreadcrumbs($Entity)
  {
    // Guarda los items que forman los breadcrumb
    $items = array();

    while($Entity != null) {
      $items[] = array(
        'text' => ($Entity instanceof Post ? $Entity->title : $Entity->name),
        'url' => $Entity->getURL()
      );

      $Entity = $Entity->getParent('Category');
    }
    $items = array_reverse($items);
    $this->renderView('layout/breadcrumbs.php', array('items' => $items));
  }

  /**
   * Devuelve TRUE si el usuario actual ya esta firmado, de lo contrario devuelve FALSE
   *
   * @return bool
   */
  protected function userAreSigned()
  {
    return (!$this->User->isNew());
  }

  /**
   * Manda a buffer el código HTML para mostrar la lista de sub-categorias que
   * existen en la categoria $TopCategory
   *
   * @param Category $TopCategory Categoria
   */
  protected function renderCategoryList(Category $TopCategory)
  {
    $this->renderView('layout/category-list.php', array('TopCategory' => $TopCategory));
  }

  /**
   * Manda a buffer el código HTML para mostrar la lista de posts que
   * existen en la categoria $Category, usando paginación de resultados con $page.
   *
   * @param Category $Category Categoria
   * @param int $page Número de la pagina de resultados
   */
  protected function renderCategoryPostsList(Category $Category, $page)
  {
    $this->renderView('layout/posts-list.php', array('posts' => $Category->getPosts($page)));
  }

  /**
   * Manda a buffer el código HTML necesario para mostrar la información de $LastPost
   * en las secciones donde se necesita mostrar el ultimo post (o comentario), si
   * $LastPost es NULL entonces solo se muestra el texto "- - -" en lugar de la
   * información del Post.
   * 
   * @param Post $LastPost Instancia de Post
   */
  protected function renderLastPost(Post $LastPost = null)
  {
    $this->renderView('layout/last-post.php', array('LastPost' => $LastPost));
  }

  /**
   * Manda a buffer el código HTML necesario para mostrar el botón para iniciar sesión.
   */
  protected function renderLoginButton()
  {
    $this->renderView('layout/login-button.php');
  }

  /**
   * Manda a buffer el código HTML para mostrar la paginación de resultados de un
   * Post, se necesita $page para mostrar el número de pagina actual
   * 
   * @param Post $Post Instancia de Post para paginar los comentarios
   * @param int $page Pagina actual
   */
  protected function renderCommentsPaginator(Post $Post, $page)
  {
    $comments_count = $Post->countChilds('Post')->exec();
    $pages_count = ceil($comments_count / COMMENTS_PER_PAGE);
    $this->renderView('layout/comments-paginator.php', array(
      'post_url'    => $Post->getURL(),
      'actual_page' => $page,
      'pages_count' => $pages_count,
    ));
  }

  /**
   * Formatea una fecha en formato MySQL a formato humano.
   * 
   * @param string $date
   * @return string Fecha formateada
   */
  protected function formatDate($date)
  {
    return strftime('%a %d, %b %Y - %R Hrs.', strtotime($date));
  }

  /**
   * Manda a buffer el código HTML para mostrar el encabezado del documento HTML
   */
  protected function header()
  {
    $this->renderView('layout/header.php');
  }

  /**
   * Manda a buffer el código HTML para mostrar el pie del documento HTML
   */
  protected function footer()
  {
    $this->renderView('layout/footer.php');
  }
}
