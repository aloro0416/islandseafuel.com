<?php
  require_once('includes/load.php');
  // Check if user has permission to delete products
  page_require_level(2);

  // Check if 'id' parameter is passed for deletion
  if (isset($_GET['id'])) {
      $media_id = (int)$_GET['id'];
      $find_media = find_by_id('media', $media_id);
      $photo = new Media();

      // If product does not exist, return an error
      if (!$find_media) {
          echo json_encode(['status' => 'error', 'message' => 'Media not found']);
          exit;
      }

      // Attempt to delete the product
      $delete_id = delete_by_id('media', $media_id);

      if($photo->media_destroy($delete_id['id'],$delete_id['file_name'])) {
          // Return success response
          echo json_encode(['status' => 'success', 'message' => 'Photo has been deleted']);
      } else {
          // Return error response if deletion failed
          echo json_encode(['status' => 'error', 'message' => 'Photo deletion failed Or Missing Prm.']);
      }
  } else {
      echo json_encode(['status' => 'error', 'message' => 'No media ID specified']);
  }
?>
