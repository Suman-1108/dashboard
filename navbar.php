<?php
  $current_page = isset($_GET['page']) ? ucfirst($_GET['page']) : 'Dashboard';
?>
<h1 style="position:absolpadding: 2px;"><?php echo $current_page; ?></h1> 
<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
  <span class="sr-only">Toggle navigation</span>
</a>