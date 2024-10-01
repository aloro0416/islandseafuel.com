<?php
  require_once('includes/load.php');
session_unset();
session_destroy();
  if(!$session->logout()) {redirect(".");}
?>
