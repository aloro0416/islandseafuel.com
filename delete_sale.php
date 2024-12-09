<?php
require_once('includes/load.php');

// Checkin what level user has permission to view this page
page_require_level(3);

// Ensure the sale ID is passed and is valid
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $sale_id = (int)$_GET['id'];

    // Find the sale by ID
    $d_sale = find_by_id('sales', $sale_id);
    if (!$d_sale) {
        // Sale not found
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing sale id.'
        ]);
        exit;
    }

    // Attempt to delete the sale
    $delete_id = delete_by_id('sales', $d_sale['id']);
    if ($delete_id) {
        // Success
        echo json_encode([
            'status' => 'success',
            'message' => 'Sale deleted successfully.'
        ]);
    } else {
        // Failure
        echo json_encode([
            'status' => 'error',
            'message' => 'Sale deletion failed.'
        ]);
    }
} else {
    // No ID was provided
    echo json_encode([
        'status' => 'error',
        'message' => 'No sale ID provided.'
    ]);
}
?>
