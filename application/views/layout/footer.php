  </div>
  <!-- // .container -->
  <div id="footer">
    <div class="container">
      <div class="row">
        <div class="span6">
          <h3><?php echo $this->QuarkStr->esc(QUARKPHP_FORUM); ?></h3>
          &copy; 2013<?php
          if (date('Y') > 2013):
            echo '-', date('Y');
          endif; ?>
          Sahib Alejandro Jaramillo Leo<br/>
          Desarrollado con QuarkPHP Framework <?php echo Quark::VERSION; ?><br/>
        </div>
        <div class="span6">
          <strong>Contacto:</strong><br/>
          <a href="http://twitter.com/quarkphp" target="_blank">@quarkphp</a><br/>
          <a href="http://twitter.com/sahibalejandro" target="_blank">@sahibalejandro</a><br/>
        </div>
      </div>
    </div>
  </div>
  <?php
  $this->prependJsFiles('bootstrap.min.js', 'quark-forum.js')->includeJsFiles();
  ?>
</body>
</html>
