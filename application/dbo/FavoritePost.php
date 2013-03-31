<?php
class FavoritePost extends QuarkDBObject
{
  const TABLE      = 'favorite_posts';
  const CONNECTION = 'default';

  public static function query()
  {
    return new QuarkDBQuery(__CLASS__);
  }
}
