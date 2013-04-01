<strong>Utilizar formato:</strong>
<label class="radio">
  <input type="radio" name="format" value="txt"
  <?php echo $default_option == 'txt' ? 'checked="checked"' : ''; ?>>
  Texto plano
</label>
<label class="radio">
  <input type="radio" name="format" value="md"
  <?php echo $default_option == 'md' ? 'checked="checked"' : ''; ?>>
  Markdown <a href="http://es.wikipedia.org/wiki/Markdown" rel="nofollow" target="_blank">[?]</a>
</label>
