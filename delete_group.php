<?php
  require_once('includes/load.php');
  // Check if user has permission to delete products
  page_require_level(1);

  // Check if 'id' parameter is passed for deletion
  if (isset($_GET['id'])) {
      $group_id = (int)$_GET['id'];
      $group_name = find_by_id('user_groups', $group_id);

      // If product does not exist, return an error
      if (!$group_name) {
          echo json_encode(['status' => 'error', 'message' => 'Name not found']);
          exit;
      }

      // Attempt to delete the product
      $delete_id = delete_by_id('user_groups', $group_id);

      if ($delete_id) {
          // Return success response
          echo json_encode(['status' => 'success', 'message' => 'Group name deleted successfully']);
      } else {
          // Return error response if deletion failed
          echo json_encode(['status' => 'error', 'message' => 'Group name deletion failed']);
      }
  } else {
      echo json_encode(['status' => 'error', 'message' => 'No group ID specified']);
  }
?>
