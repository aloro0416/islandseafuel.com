<?php
  require_once('includes/load.php');
  // Check if user has permission to delete products
  page_require_level(1);

  // Check if 'id' parameter is passed for deletion
  if (isset($_GET['id'])) {
      $user_id = (int)$_GET['id'];
      $user = find_by_id('users', $user_id);

      // If product does not exist, return an error
      if (!$user) {
          echo json_encode(['status' => 'error', 'message' => 'User not found']);
          exit;
      }

      // Attempt to delete the product
      $delete_id = delete_by_id('users', $user_id);

      if ($delete_id) {
          // Return success response
          echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
      } else {
          // Return error response if deletion failed
          echo json_encode(['status' => 'error', 'message' => 'User deletion failed']);
      }
  } else {
      echo json_encode(['status' => 'error', 'message' => 'No user ID specified']);
  }
?>