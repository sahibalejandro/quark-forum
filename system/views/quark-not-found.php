<!--
QuarkPHP Framework
Copyright 2012-2013 Sahib Alejandro Jaramillo Leo

http://quarkphp.com
GNU General Public License (http://www.gnu.org/licenses/gpl.html)
 -->
<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <title>404 Not found</title>
  <link rel="stylesheet" type="text/css" href="<?php echo $this->QuarkURL->getBaseURL(); ?>system/public/css/quark.css">
</head>
<body>
  <h2>404 - Not found.</h2>
  <p>The page or file you're looking for does not exists.</p>
  <p><a href="<?php echo $this->QuarkURL->getBaseURL(); ?>">Back to main page</a></p>
  <div id="footer">
    This web site is builded with QuarkPHP v<?php echo Quark::VERSION; ?>
    - <a href="http://quarkphp.com">http://quarkphp.com</a>
  </div>
</body>
</html>
