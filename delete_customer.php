<?php
  require_once('includes/load.php');
  
  // Check if the delete parameter is set in the GET request
  if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Prepare the SQL query to delete the customer by ID
    $sql = "DELETE FROM customer WHERE id='$id'";

    // Execute the query
    $result = $db->query($sql);

    // Check if the query was successful
    if ($result) {
        echo 'success';  // Return success message if deletion is successful
    } else {
        echo 'error';    // Return error message if deletion fails
    }
  }
?>
