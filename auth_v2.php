<?php 
include_once('includes/load.php'); 

// Initialize error array
$errors = array();

// Validate the required fields
$req_fields = array('username', 'password');
validate_fields($req_fields);  // Assuming this function is defined in 'load.php'

// Collect and sanitize user input
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

// Check if there were any validation errors
if (empty($errors)) {

    // Authenticate the user using the username and password
    $user = authenticate_v2($username, $password);

    if ($user) {
        // Check if the password matches
        if (password_verify($password, $user['password'])) {
            // Create session with user ID
            $session->login($user['id']);
            
            // Update the last login time
            updateLastLogIn($user['id']);
            
            // Redirect user based on their user level
            switch ($user['user_level']) {
                case '1':
                    $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
                    redirect('admin', false);
                    break;
                
                case '2':
                    $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
                    redirect('special', false);
                    break;
                
                default:
                    $session->msg("s", "Hello ".$user['username'].", Welcome to OSWA-INV.");
                    redirect('home', false);
                    break;
            }
        } else {
            // Password incorrect
            $session->msg("d", "Sorry, Username/Password is incorrect.");
            redirect('.', false);
        }
    } else {
        // Authentication failed
        $session->msg("d", "Sorry, Username/Password is incorrect.");
        redirect('.', false);
    }
} else {
    // Handle validation errors
    $session->msg("d", implode(", ", $errors));
    redirect('login_v2', false);
}

?>
