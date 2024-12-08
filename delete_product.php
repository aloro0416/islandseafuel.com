<?php
  require_once('includes/load.php');
  // Check if user has permission to delete products
  page_require_level(2);

  // Check if 'id' parameter is passed for deletion
  if (isset($_GET['id'])) {
      $product_id = (int)$_GET['id'];
      $product = find_by_id('products', $product_id);

      // If product does not exist, return an error
      if (!$product) {
          echo json_encode(['status' => 'error', 'message' => 'Product not found']);
          exit;
      }

      // Attempt to delete the product
      $delete_id = delete_by_id('products', $product_id);

      if ($delete_id) {
          // Return success response
          echo json_encode(['status' => 'success', 'message' => 'Product deleted successfully']);
      } else {
          // Return error response if deletion failed
          echo json_encode(['status' => 'error', 'message' => 'Product deletion failed']);
      }
  } else {
      echo json_encode(['status' => 'error', 'message' => 'No product ID specified']);
  }
?>
