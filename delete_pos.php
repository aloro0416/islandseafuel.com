<?php
  require_once('includes/load.php');
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM pos WHERE id='$id'";
    $result = $db->query($sql);

    header('location: pos.php?');
}