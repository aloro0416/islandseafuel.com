<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $find_media = find_by_id('media',(int)$_GET['id']);
  $photo = new Media();
  if($photo->media_destroy($find_media['id'],$find_media['file_name'])){
      $session->msg("s","Photo has been deleted.");
      redirect('media');
  } else {
      $session->msg("d","Photo deletion failed Or Missing Prm.");
      redirect('media');
  }
?>
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

      if($photo->media_destroy($find_media['id'],$find_media['file_name'])) {
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
