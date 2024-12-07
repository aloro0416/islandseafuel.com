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
            $user_id = authenticate($username, $password);

            if ($user_id) {

                if (password_verify($password, $password)){
                // Create session with user id
                $session->login($user_id);

                // Update the last login time
                updateLastLogIn($user_id);

                // Success message and redirect
                $session->msg("s", "Welcome to Island Sea Management System");
                redirect('admin', false);
                } else {
                    // Authentication failed (incorrect username/password)
                    $session->msg("d", "Sorry, Username/Password is incorrect.");
                    redirect('.', false);
                }
            } else {
                // Authentication failed (incorrect username/password)
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
