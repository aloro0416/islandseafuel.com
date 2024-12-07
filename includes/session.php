<?php
session_start();

class Session {

    public $msg;
    private $user_is_logged_in = false;

    function __construct() {
        $this->userLoginSetup();
    }

    public function isUserLoggedIn() {
        return $this->user_is_logged_in;
    }

    public function login($user_id) {
        $_SESSION['user_id'] = $user_id;
    }

    private function userLoginSetup() {
        if (isset($_SESSION['user_id'])) {
            $this->user_is_logged_in = true;
        } else {
            $this->user_is_logged_in = false;
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
    }

    // Store message and type
    public function msg($type = '', $msg = '') {
        if (!empty($msg)) {
            if (strlen(trim($type)) == 1) {
                $type = str_replace(array('d', 'i', 'w', 's'), array('danger', 'info', 'warning', 'success'), $type);
            }
            $_SESSION['msg'][$type] = $msg;
        } else {
            return $this->msg;
        }
    }

    // Use SweetAlert for the message display
    private function flash_msg() {
        if (isset($_SESSION['msg'])) {
            $this->msg = $_SESSION['msg'];
            unset($_SESSION['msg']);
        } else {
            $this->msg;
        }
    }
}

$session = new Session();

// Example of using the msg method:
$session->msg('s', 'Success! You have logged in.'); // 's' for success

?>

<!-- Include SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
<?php if (isset($session->msg)): ?>
    <?php foreach ($session->msg as $type => $message): ?>
        Swal.fire({
            icon: '<?php echo $type; ?>',
            title: '<?php echo ucfirst($type); ?>',
            text: '<?php echo $message; ?>'
        });
    <?php endforeach; ?>
<?php endif; ?>
</script>
