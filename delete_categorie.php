<?php
  require_once('includes/load.php');
  // Check if user has permission to delete products
  page_require_level(1);

  // Check if 'id' parameter is passed for deletion
  if (isset($_GET['id'])) {
      $categorie_id = (int)$_GET['id'];
      $categorie = find_by_id('categorie', $categorie_id);

      // If categorie does not exist, return an error
      if (!$categorie) {
          echo json_encode(['status' => 'error', 'message' => 'Missing Categorie id']);
          exit;
      }

      // Attempt to delete the categorie
      $delete_id = delete_by_id('categorie', $categorie_id);

      if ($delete_id) {
          // Return success response
          echo json_encode(['status' => 'success', 'message' => 'Categorie deleted successfully']);
      } else {
          // Return error response if deletion failed
          echo json_encode(['status' => 'error', 'message' => 'Categorie deletion failed']);
      }
  } else {
      echo json_encode(['status' => 'error', 'message' => 'No categorie ID specified']);
  }
?>
