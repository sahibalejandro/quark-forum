<?php
class WatchedPost extends QuarkDBObject
{
  const TABLE      = 'watched_posts';
  const CONNECTION = 'default';

  public static function query()
  {
    return new QuarkDBQuery(__CLASS__);
  }
}
