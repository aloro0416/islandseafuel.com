<?php
  require_once('includes/load.php');

  // Ensure user is logged in and the session user_id exists
  if (isset($session->user_id)) {
      // Get the current user's ID
      $user_id = $session->user_id;

      // Prepare the SQL query to update the user's status to 0
      $query = "UPDATE users SET status = 0 WHERE id = '{$user_id}'";
      
      // Execute the query
      if ($db->query($query)) {
          // Optionally, you can check if the update was successful, e.g., by checking affected rows
          // if ($db->affected_rows() > 0) { ... }
      } else {
          // Handle the case where the query fails
          echo "Error updating status.";
      }
  }

  // Log out the user
  if (!$session->logout()) {
      redirect(".");
  }
?>
