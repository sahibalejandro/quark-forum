<?php
class Category extends QuarkDBObject
{
  const TABLE      = 'categories';
  const CONNECTION = 'default';

  private $url;

  public function getLastPost()
  {
    return Post::query()->selectOne()
      ->join('User')
      ->where(array('categories_id' => $this->id, 'posts_id' => null))
      ->orderBy('id', 'desc')
      ->exec();
  }

  public function getPosts($page = 1)
  {
    // Global posts
    $global_posts = Post::query()->select()
      ->join('User')
      ->where(array('posts_id' => null, 'categories_id' => null))
      ->exec();

    // Sticky posts
    $sticky_posts = Post::query()->select()
      ->join('User')
      ->where(array(
        'categories_id' => $this->id,
        'posts_id'      => null,
        'sticky'         => 1
      ))
      ->orderBy('id', 'desc')
      ->exec();

    // Post no sticky
    $no_sticky_posts = Post::query()->select()
      ->join('User')
      ->where(array(
        'categories_id' => $this->id,
        'posts_id'      => null,
        'sticky'         => 0
      ))
      ->page($page, 10)
      ->orderBy('id', 'desc')
      ->exec();

    return array_merge($global_posts, $sticky_posts, $no_sticky_posts);
  }

  private function extend()
  {
    if (!$this->isNew()) {
      $QuarkURL = new QuarkURL();
      $this->url = $QuarkURL->getURL('category/'.$this->id);
    }
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

  public function hasSubCategories()
  {
    return ($this->countChilds('Category')->exec() > 0);
  }

  public function getPostsCount()
  {
    return $this->countChilds('Post')->where(array('posts_id' => null))->exec();
  }

  public static function query()
  {
    return new QuarkDBQuery(__CLASS__);
  }
}
