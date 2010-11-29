<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php echo javascript_include_tag('extjs/adapter/ext/ext-base.js') ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
	<script>
	URL_AGILHU= '<?php echo (url_for('default/index'));?>';
	</script>
  </head>
  <body>
    <?php echo $sf_content ?>
  </body>
</html>
