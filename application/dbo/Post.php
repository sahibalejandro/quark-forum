<?php
class Post extends QuarkDBObject
{
  const TABLE      = 'posts';
  const CONNECTION = 'default';

  private $url;

  public static function findCommentPage($post_id, $comment_id)
  {
    // Primero nos aseguramos que exista el post (comentario) solicitado
    $count = Post::query()->count()->where(array(
      'id'       => $comment_id,
      'posts_id' => $post_id,
    ))->exec();
    
    if ($count == 0) {
      // El post (comentario) no existe, no es necesario buscar.
      return null;
    } else {
      /* Iterar sobre todas las paginas de resultados, hasta encontrar el
       * post (comentario) solicitado, asi sabremos en que página está */
      $page      = 0;
      $exit_loop = false;
      do {
        $page++;
        $rows = Post::query()->select('id')
          ->where(array('posts_id' => $post_id))
          ->page($page, COMMENTS_PER_PAGE)
          ->asArray()
          ->exec();

        if (count($rows) == 0) {
          // Ya no hay mas registros que buscar, por lo cual no se encontró la pagina.
          $page      = null;
          $exit_loop = true;
        } else {
          // Iterar entre los resultados para buscar el ID del comentario
          foreach ($rows as $row) {
            if ($row['id'] == $comment_id) {
              // Comentario encontrado en la pagina actual, salimos
              $exit_loop = true;
              break;
            }
          }
        }

      } while ($exit_loop == false);
      
      return $page;
    }
  }

  private function extend()
  {
    if (!$this->isNew()) {
      $QuarkURL = new QuarkURL();
      if ($this->posts_id == null) {
        $this->url = $QuarkURL->getURL('post/'.$this->id);
      } else {
        $this->url = $QuarkURL->getURL('comment/'.$this->id);
      }
    }
  }

  public function getCommentsPage($page)
  {
    return $this->getChilds(__CLASS__)
      ->join('User')
      ->page($page, COMMENTS_PER_PAGE)
      ->orderBy('id')
      ->exec();
  }

  public function getCommentsCount()
  {
    return $this->countChilds(__CLASS__)->exec();
  }

  public function getFavoriteCount()
  {
    return $this->countChilds('FavoritePost')->exec();
  }

  public function getWatchedCount()
  {
    return $this->countChilds('WatchedPost')->exec();
  }

  public function isComment()
  {
    return ($this->posts_id != null);
  }

  public function getLastComment()
  {
    return self::query()->selectOne()
      ->join('User')
      ->where(array('posts_id' => $this->id))
      ->orderBy('id', 'desc')
      ->exec();
  }

  /**
   * Devuelve el contenido procesado del post.
   * 
   * @return string
   */
  public function getContent()
  {
    switch ($this->format) {
      case 'md': // Markdown
        return Markdown($this->content);
        break;
      default:
        return $this->content;
        break;
    }
  }

  public function isGlobal()
  {
    return ($this->posts_id == null && $this->categories_id == null);
  }

  public function inflate($a)
  {
    parent::inflate($a);
    $this->extend();
  }

  public function getURL()
  {
    return $this->url;
  }

  public static function query()
  {
    return new QuarkDBQuery(__CLASS__);
  }

  protected function validate()
  {
    // Verificar título del post, solo los comentarios pueden ignorar el titulo.
    $this->title   = trim($this->title);
    if ($this->title == '') {
      $this->title = null;
    }
    if ($this->posts_id == null && $this->title == null) {
      $this->setErrorMsg('Debe especificar el título.');
      return false;
    }

    // Verificar el contenido, no puede estar vacio
    $this->content = trim($this->content);
    if ($this->content == '') {
      $this->setErrorMsg('Debe especificar el contenido.');
      return false;
    }

    return true;
  }
}
