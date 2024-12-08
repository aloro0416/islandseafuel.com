<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
        <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px">
       <h4>ISLAND SEA MANAGEMENT SYSTEM</h4>
     </div>
     <?php if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']): ?>
        <?php
        $lockout_time_remaining = $_SESSION['lockout_time'] - time();
        $minutes_remaining = ceil($lockout_time_remaining / 60);
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const formInputs = document.querySelectorAll('#username, #myInput');
                const loginButton = document.getElementById('btn-login');
                
                formInputs.forEach(input => input.disabled = true);
                loginButton.disabled = true;

                Swal.fire({
                    title: 'Account Locked',
                    text: "Your account is locked. Please wait " + <?php echo $minutes_remaining; ?> + " minute(s) before trying again.",
                    icon: 'warning',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then(() => {
                    setTimeout(function() {
                        window.location.reload(); 
                    }, 1000);
                });
            });
        </script>
    <?php endif; ?>
     <!-- Include Google reCAPTCHA v3 Script -->
     <script src="https://www.google.com/recaptcha/api.js?render=6Lcc25IqAAAAAH635KLYx5TwcXhguTYoIdJzgceI"></script>

     <form method="post" action="auth.php" class="clearfix" id="loginForm">
        <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="name" class="form-control" name="username" id="username" placeholder="Username" <?php if (isset($lockout_time_remaining)) echo 'disabled'; ?> disabled>
        </div>
        <div class="form-group" style="position: relative;">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name="password" class="form-control" id="myInput" placeholder="Password" <?php if (isset($lockout_time_remaining)) echo 'disabled'; ?> disabled>
            
            <!-- Eye icon positioned inside the input box -->
            <i class="fa fa-eye" onclick="myFunction()" id="togglePassword" style="position: absolute; right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;"></i>
        </div>
        <div class="form-group">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
            <label class="form-check-label" for="exampleCheck1">
                I agree to the 
                <a href="#" id="openModalLink" data-bs-toggle="modal" data-bs-target="#myModal">Terms and Conditions</a>
            </label>
        </div>
        <!-- Hidden reCAPTCHA token input will be added here -->
        <div class="form-group">
            <button type="submit" id="btn-login" class="btn btn-danger" style="border-radius:0%" <?php if (isset($lockout_time_remaining)) echo 'disabled'; ?> disabled>Login</button>
        </div>
        <div class="text-center">
            <a href="account_recovery_select.php">Forgot password?</a>
        </div>
    </form>

    <!-- The Modal -->
    <div class="modal1" id="myModal">
                    <div class="modal-dialog1 modal-dialog-scrollable">
                        <div class="modal-content1">

                        <!-- Modal Header -->
                        <div class="modal-header1">
                            <h4 class="modal-title1">Terms and Condition</h4>
                            <button type="button" class="close-btn1" data-bs-dismiss="modal" id="closeModalBtn">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body1" style="text-align:left;">
                            <h3 style="margin-bottom:5px;">General Terms and Conditions for Data Privacy Act of 2012 Compliance</h3>
                            <p style="margin-bottom:5px;font-weight:bold;">1. Principles of Data Privacy</p>
                            <p style="magin-bottom:5px;">Organizations must adhere to these principles when handling personal data:</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li><b>Transparency:</b> Inform data subjects about how their data will be collected, processed, and used.</li>
                                <li><b>Legitimate Purpose:</b> Collect data only for lawful and specific purposes.</li>
                                <li><b>Proportionality:</b> Collect and process only data that is necessary for the declared purpose.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">2. Data Subject Rights</p>
                            <p style="magin-bottom:5px;">Individuals have the right to:</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Be informed about the processing of their personal data.</li>
                                <li>Access their data.</li>
                                <li>Object to data processing.</li>
                                <li>Correct or update their data.</li>
                                <li>Erase or block their data under certain conditions.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">3. Consent</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Obtain explicit, informed, and voluntary consent from the data subject before processing personal data.</li>
                                <li>Clearly state the purpose of data collection at the time of obtaining consent.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">4. Security Measures</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Implement organizational, physical, and technical security measures to protect personal data from unauthorized access, processing, and disposal.</li>
                                <li>Regularly review and update security measures to address emerging threats.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">5. Data Processing Standards</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Process data lawfully and in compliance with the declared purposes.</li>
                                <li>Retain data only for as long as necessary to fulfill the purpose of processing.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">6. Data Sharing and Transfer</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Obtain consent before sharing personal data with third parties, except when allowed by law.</li>
                                <li>Ensure third parties comply with the same data protection standards.</li>
                                <li>For international data transfers, ensure the recipient country has adequate data protection measures.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">7. Data Breach Management</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Notify the National Privacy Commission (NPC) and affected individuals within 72 hours of discovering a breach that poses a risk to data subjects.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">8. Appointment of a Data Protection Officer (DPO)</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Designate a DPO responsible for ensuring compliance with the DPA and acting as the point of contact for the NPC and data subjects.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">9. Regular Compliance Audits</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Conduct regular privacy impact assessments and audits to ensure compliance with the DPA and its implementing rules.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">10. Accountability</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Maintain records of processing activities.</li>
                                <li>Train staff on data privacy principles and policies.</li>
                            </ul>
                            <hr style="margin-top:20px;margin-bottom:10px;">
                            <p style="margin-bottom:5px;font-weight:bold;">Penalties for Non-Compliance</p>
                            <p style="magin-bottom:5px;">The DPA of 2012 imposes penalties for violations, including:</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Fines ranging from PHP 500,000 to PHP 5 million.</li>
                                <li>Imprisonment ranging from 1 to 6 years, depending on the severity of the violation.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">Regulatory Authority</p>
                            <p style="magin-bottom:5px;">The <b>National Privacy Commission (NPC)</b> oversees the enforcement of the DPA and issues guidelines and advisories to ensure compliance.</p>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer1">
                            <button type="button" class="btn btn-danger btn-close1" data-bs-dismiss="modal" id="closeModalBtnFooter">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>

    <!-- JavaScript for reCAPTCHA token generation -->
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6Lcc25IqAAAAAH635KLYx5TwcXhguTYoIdJzgceI', {action: 'login'}).then(function(token) {
                // Add the token as a hidden input field in the form
                var recaptchaInput = document.createElement('input');
                recaptchaInput.type = 'hidden';
                recaptchaInput.name = 'recaptcha_token';
                recaptchaInput.value = token;
                document.getElementById('loginForm').appendChild(recaptchaInput);
            });
        });
    </script>

<script>
   function myFunction() {
        var x = document.getElementById("myInput");
        var eyeIcon = document.getElementById("togglePassword");
        
        if (x.type === "password") {
            x.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            x.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }

// Select form input elements to disable initially
const formInputs = document.querySelectorAll('#username, #myInput');
        const loginButton = document.getElementById('btn-login');

        // Function to request and check location permissions
        function requestLocation() {
        if (navigator.geolocation) {
            <?php if (!isset($lockout_time_remaining) || time() >= $_SESSION['lockout_time']): ?>
                navigator.geolocation.watchPosition(
                    function (position) {
                        console.log('Location access granted');
                        formInputs.forEach(input => input.disabled = false);
                        loginButton.disabled = false;
                    },
                    function (error) {
                        if (error.code === error.PERMISSION_DENIED) {
                            Swal.fire({
                                title: 'Permission Denied',
                                text: "Please allow location access to use this login page.",
                                icon: 'warning',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            }).then(() => {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            });
                        }

                        if (error.code === error.POSITION_UNAVAILABLE || error.code === error.TIMEOUT) {
                            Swal.fire({
                                title: 'Location Lost',
                                text: "Location access was lost. The form will reload.",
                                icon: 'error',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            }).then(() => {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            });
                        }
                    }
                );
            <?php endif; ?>
        } else {
            Swal.fire({
                title: 'Geolocation Not Supported',
                text: "Geolocation is not supported by this browser.",
                icon: 'error',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        requestLocation();
    });
</script>

</div>

<style>
  body {
    background-image: url('libs/images/bgi2.jpg');
    background-size: cover; /* Ensures the image covers the entire screen */
    background-position: center;
    background-attachment: fixed; /* Keeps the background fixed while scrolling */
  }

  .login-page {
    box-shadow: 2px 2px 5px 2px;
  }

  /* Media query for mobile devices */
  @media (max-width: 768px) {
    body {
      background-size: contain; /* Adjusts the background size for smaller screens */
      background-position: top center; /* Aligns the image to the top center for better display on mobile */
      background-attachment: scroll; /* Fixes the background scrolling issue on mobile */
      padding: 35px 15px 20px 15px; /* Adjust padding for smaller screens */
      top: 20px; /* Reduce the top margin for mobile */
      left: 0;
      width: 100%; /* Ensure full-width on smaller screens */
    }
  }
</style>


<?php include_once('layouts/footer.php'); ?>
