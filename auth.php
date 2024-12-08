<?php include_once('includes/load.php'); ?>
<?php

// Initialize session variables if not already set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = null;
}

// Check if user is locked out
if ($_SESSION['lockout_time'] && time() < $_SESSION['lockout_time']) {
    $lockout_time_remaining = $_SESSION['lockout_time'] - time();
    $minutes_remaining = ceil($lockout_time_remaining / 60);
    header("Location: .");
    exit(0);
}

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
    $_SESSION['status'] = 'reCAPTCHA validation failed. Please try again.';
    $_SESSION['status_code'] = 'error';
    header('Location: .');
    exit(0);
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
                // Create session with user id
                $session->login($user_id);

                session_regenerate_id(true);

                $_SESSION['login_attempts'] = 0;
                $_SESSION['lockout_time'] = null;

                // Update the last login time
                updateLastLogIn($user_id);

                $_SESSION['login_success'] = true;
                header("Location: .");
                exit(0);
            } else {
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= 3){
                    $_SESSION['lockout_time'] = time() + 300;
                } else {
                    $_SESSION['status'] = 'Sorry, Username/Password is incorrect.';
                    $_SESSION['status_code'] = 'error';
                    header('Location: .');
                    exit(0);
                }
            }

        } else {
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['lockout_time'] = time() + 300;
            } else {
                $_SESSION['status'] = $errors;
                $_SESSION['status_code'] = 'error';
                header('Location: .');
                exit(0);
            }
        }

    } else {
        $_SESSION['status'] = "reCAPTCHA validation failed. Please try again.";
        $_SESSION['status_code'] = 'error';
        header('Location: .');
        exit(0);
    }
}

?>
