<?php
 session_start();

class Session {

 public $msg;
 private $user_is_logged_in = false;

 function __construct(){
   $this->flash_msg();
   $this->userLoginSetup();
 }

  public function isUserLoggedIn(){
    return $this->user_is_logged_in;
  }
  public function login($user_id){
    $_SESSION['user_id'] = $user_id;
  }
  private function userLoginSetup()
  {
    if(isset($_SESSION['user_id']))
    {
      $this->user_is_logged_in = true;
    } else {
      $this->user_is_logged_in = false;
    }

  }
  public function logout() {
    require_once('includes/load.php');
    // Assuming you have a global MySQLi connection object
    global $db; // This should be your MySQLi connection object, not PDO

    // Check if user is logged in and user_id is available in session
    if (isset($_SESSION['user_id'])) {
        // Update the user's status in the database
        $user_id = $_SESSION['user_id'];
        
        // Prepare and execute the SQL query using MySQLi
        $stmt = $db->prepare("UPDATE users SET status = 0 WHERE id = ?");
        $stmt->bind_param("i", $user_id); // "i" indicates an integer parameter
        $stmt->execute();
        $stmt->close();
    }

    // Unset session variables and destroy the session
    unset($_SESSION['user_id']);
    session_destroy();

    // Check if session cookie exists, and delete it
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 20, '/');
    }

    // Clear session array
    $_SESSION = array();
}

  public function msg($type ='', $msg =''){
    if(!empty($msg)){
       if(strlen(trim($type)) == 1){
         $type = str_replace( array('d', 'i', 'w','s'), array('danger', 'info', 'warning','success'), $type );
       }
       $_SESSION['msg'][$type] = $msg;
    } else {
      return $this->msg;
    }
  }

  private function flash_msg(){

    if(isset($_SESSION['msg'])) {
      $this->msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
    } else {
      $this->msg;
    }
  }
}

$session = new Session();
$msg = $session->msg();

?>
