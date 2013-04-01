<?php
class User extends QuarkDBObject
{
  const TABLE      = 'users';
  const CONNECTION = 'default';

  private $link;
  private $url;

  /**
   * Devuelve TRUE si el usuario actual puede editar el Post $Post, de lo contrario
   * devuelve FALSE
   * 
   * @param Post $Post Instancia de Post para verificar (puede ser un post o comentario)
   * @return bool
   */
  public function canEditPost(Post $Post)
  {
    return (!$this->isNew() && ($this->type == 'A' || $this->type == 'M' || $this->id == $Post->users_id));
  }

  public function isWatchingPost(Post $Post)
  {
    if ($this->isNew()) {
      return false;
    } else {
      return (WatchedPost::query()->count()->where(array('posts_id' => $Post->id, 'users_id' => $this->id))->exec() === 1);
    }
  }

  public function isFavoritePost(Post $Post)
  {
    if ($this->isNew()) {
      return false;
    } else {
      return (FavoritePost::query()->count()->where(array('posts_id' => $Post->id, 'users_id' => $this->id))->exec() === 1);
    }
  }

  private function extend()
  {
    if (!$this->isNew()) {
      $QuarkURL   = new QuarkURL();
      $this->url  = $QuarkURL->getURL('users/'.$this->id);
      $this->link = '<a href="'.$this->url.'">'.$this->name.'</a>';
    }
  }

  public function inflate($a)
  {
    parent::inflate($a);
    $this->extend();
  }

  public function getLink()
  {
    return $this->link;
  }

  public function getURL()
  {
    return $this->url;
  }

  public static function query()
  {
    return new QuarkDBQuery(__CLASS__);
  }
}
