<?php
// Start session
session_start();

// Include database connection file
require '/storage/ssd1/635/21963635/public_html/Personal/database.php';

// Initialize variables to store error messages and user inputs
$errors = array();
$email = '';
$password = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['pass'] ?? '';

    // Validate if email and password fields are not empty
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // If there are no errors, proceed to check the user's credentials
    if (count($errors) == 0) {
        // Prepare a select statement to check if the user exists with the entered email
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start a new session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];

                // Redirect to a new page (e.g., user's dashboard)
                header("Location: https://odoruame.000webhostapp.com/Personal/index.php");
                exit();
            } else {
                // If password is incorrect
                array_push($errors, "Invalid email/password combination");
            }
        } else {
            // If no user found with the entered email
            array_push($errors, "No user found with that email");
        }

        $stmt->close();
    }

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login Form</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link
      rel="stylesheet"
      type="text/css"
      href="vendor/bootstrap/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="fonts/font-awesome-4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="fonts/iconic/css/material-design-iconic-font.min.css"
    />
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css" />
    <link
      rel="stylesheet"
      type="text/css"
      href="vendor/css-hamburgers/hamburgers.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="vendor/animsition/css/animsition.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="vendor/select2/select2.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="vendor/daterangepicker/daterangepicker.css"
    />
    <link rel="stylesheet" type="text/css" href="css/util.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
  </head>
  <body>
    <div class="limiter">
      <div
        class="container-login100"
        style="background-image: url('images/bg-01.jpg')"
      >
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
          <form action="login.php" method="post" class="login100-form validate-form">
            <span class="login100-form-title p-b-49"> Login </span>

            <div
              class="wrap-input100 validate-input m-b-23"
              data-validate="Email is required"
            >
              <span class="label-input100">Email Address</span>
              <input
                class="input100"
                type="text"
                name="email"
                placeholder="Type your email"
              />
              <span class="focus-input100" data-symbol="&#xf206;"></span>
            </div>

            <div
              class="wrap-input100 validate-input"
              data-validate="Password is required"
            >
              <span class="label-input100">Password</span>
              <input
                class="input100"
                type="password"
                name="pass"
                placeholder="Type your password"
              />
              <span class="focus-input100" data-symbol="&#xf190;"></span>
            </div>
            <br />
            <div class="container-login100-form-btn">
              <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button class="login100-form-btn">Login</button>
              </div>
            </div>

            <div class="flex-col-c p-t-50 p-b-40">
              <span class="txt1 p-b-17"> Don't have an account? </span>
              <a href="https://odoruame.000webhostapp.com/Register%20Form/register.php" class="txt2"> Sign Up </a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="dropDownSelect1"></div>

    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <script src="js/login.js"></script>
  </body>
</html>