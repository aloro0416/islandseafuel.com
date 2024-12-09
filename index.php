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
            <label>
                <input type="checkbox"> I agree to the
                <a href="#" id="openModalLink">Terms and Condition</a>
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

    <!-- Modal Structure -->
    <div id="termsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 style="margin-bottom:5px;">General Terms and Conditions for Data Privacy Act of 2012 Compliance</h3>
                <div class="terms-text">
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
      background-size: cover; /* Adjusts the background size for smaller screens */
      background-position: center; /* Aligns the image to the top center for better display on mobile */
      background-attachment: fixed; /* Fixes the background scrolling issue on mobile */
      width: 100%; /* Ensure full-width on smaller screens */
    }
    .login-page {
        width: 100%;
    }
  }

#termsModal {
    display: none;
    position: absolute;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}

.modal-content {
    background-color: white;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
    max-width: 600px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    max-height: 100vh;
}

.terms-text {
    max-height: 300px;
    overflow-y: auto;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    margin-top: -10px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

<script>
    // Get the modal
    var modal = document.getElementById("termsModal");

// Get the link that opens the modal
var link = document.getElementById("openModalLink");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the link, open the modal
link.onclick = function(event) {
    event.preventDefault(); // Prevent the default link behavior
    modal.style.display = "block"; // Show the modal
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loginButton = document.querySelector('#btn-login');
    const termsCheckbox = document.querySelector('input[type="checkbox"]');

    // Add click event listener to the login button
    loginButton.addEventListener('click', function () {
        // Automatically check the Terms and Condition checkbox
        if (termsCheckbox) {
            termsCheckbox.checked = true;
        }
    });

    // Modal handling for terms
    var modal = document.getElementById("termsModal");
    var link = document.getElementById("openModalLink");
    var span = document.getElementsByClassName("close")[0];

    link.onclick = function(event) {
        event.preventDefault();
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
</script>


<?php include_once('layouts/footer.php'); ?>
