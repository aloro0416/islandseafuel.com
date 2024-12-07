<?php include_once('includes/load.php'); ?>
<?php

// reCAPTCHA Secret Key
$secretKey = '6Lcc25IqAAAAAOVyCiaGjWfDYWXQssIBOfO-i5Pu'; // Replace with your actual Secret Key

// Required fields for the login form
$req_fields = array('username', 'password', 'recaptcha_token');
validate_fields($req_fields);

// Get the input values from the POST request
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);
$recaptchaToken = remove_junk($_POST['recaptcha_token']);

// Verify the reCAPTCHA token with Google
if (empty($recaptchaToken)) {
    $session->msg("d", "reCAPTCHA validation failed. Please try again.");
    redirect('.', false);
} else {
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaToken
    ];

    // Send request to Google reCAPTCHA API for verification
    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($verifyUrl . '?' . http_build_query($data));
    $responseKeys = json_decode($response, true);

    // Check if reCAPTCHA was successful
    if (isset($responseKeys['success']) && $responseKeys['success'] == true) {

        // No validation errors, proceed with user authentication
        if (empty($errors)) {
            // Authenticate the user based on the username
            $user = find_user_by_username($username); // Assuming this function gets the user's data by username
            
            if ($user) {
                // Verify the hashed password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, login the user
                    $session->login($user['id']);

                    // Update the last login time
                    updateLastLogIn($user['id']);

                    // Success message and redirect
                    $session->msg("s", "Welcome to Island Sea Management System");
                    redirect('admin', false);
                } else {
                    // Authentication failed (incorrect password)
                    $session->msg("d", "Sorry, Username/Password is incorrect.");
                    redirect('.', false);
                }
            } else {
                // User does not exist
                $session->msg("d", "Sorry, Username/Password is incorrect.");
                redirect('.', false);
            }

        } else {
            // Validation errors
            $session->msg("d", $errors);
            redirect('.', false);
        }

    } else {
        // reCAPTCHA verification failed
        $session->msg("d", "reCAPTCHA validation failed. Please try again.");
        redirect('.', false);
    }
}

?>
