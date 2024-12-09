<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php
if (isset($_GET['id'])) {
    $sale_id = (int)$_GET['id'];
    $sale = find_by_id('sales', $sale_id);

    if (!$sale) {
      echo json_encode(['status' => 'error', 'message' => 'Missing Sale Id']);
      exit;
    }

    $delete_id = delete_by_id('sales', $sale_id);

    if($delete_id) {
      echo json_encode(['status' => 'success', 'message' => 'Sale deleted successfully']);

    } else {
      // Return error response if deletion failed
      echo json_encode(['status' => 'error', 'message' => 'Sale deletion failed']);
    }
  } else {
    echo json_encode(['status' => 'error', 'message' => 'No sale ID specified']);
}
?>

