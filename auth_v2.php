<?php include_once('includes/load.php'); ?>

<?php
// Define required fields for login
$req_fields = array('username', 'password');
validate_fields($req_fields);

// Sanitize user inputs
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

// Initialize errors array
$errors = array();

if (empty($errors)) {
    // Authenticate user
    $user = authenticate_v2($username, $password);

    if ($user) {
        // Create session with user ID
        $session->login($user['id']);
        
        // Update last login time
        updateLastLogIn($user['id']);
        
        // Redirect user based on user level
        switch ($user['user_level']) {
            case '1':
                $session->msg("s", "Hello " . $user['username'] . ", Welcome to OSWA-INV.");
                redirect('admin.php', false);
                break;
            case '2':
                $session->msg("s", "Hello " . $user['username'] . ", Welcome to OSWA-INV.");
                redirect('special.php', false);
                break;
            default:
                $session->msg("s", "Hello " . $user['username'] . ", Welcome to OSWA-INV.");
                redirect('home.php', false);
                break;
        }
    } else {
        // Incorrect username or password
        $session->msg("d", "Sorry Username/Password incorrect.");
        redirect('index.php', false); // Ensure this correctly points to the login page if needed
    }
} else {
    // Validation errors
    $session->msg("d", implode('<br>', $errors)); // Convert array to string if necessary
    redirect('login_v2.php', false);
}
?>
