<?php
define('QUARKPHP_FORUM', 'QuarkPHP Foro');
define('COMMENTS_PER_PAGE', 8);
define('POSTS_PER_PAGE', 10);
define('REQUEST_ERROR_MSG', 'No se pudo completar la solicitud, intenta más tarde');

$config['session_name']  = 'quark-forum';
$config['debug']         = true;
$config['auto_includes'] = array('markdown.php');

$routes = array(
  'category(/.*)?' => 'home/category$1',
  'post(/.*)?'     => 'home/post$1',
  'comment(/.*)?'  => 'home/post$1',
);

$db_config['default'] = array(
  // Database host name or IP
  'host'     => '127.0.0.1',
  // Database name
  'database' => 'quark_forum',
  // Database user
  'user'     => 'root',
  // Database password
  'password' => 'rootsql',
  // Character encoding to use in the "SET NAMES" query
  'charset'  => 'UTF8',
  /* Driver specific options for the PDO object used by the ORM engine.
   * See http://www.php.net/manual/es/pdo.setattribute.php */
  'options'  => array(),
);
