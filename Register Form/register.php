<?php

require '/storage/ssd1/635/21963635/public_html/Personal/database.php'; 

$errors = array(); // Initialize an array to store potential error messages

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $lastName = $_POST['lastname'] ?? '';
    $firstName = $_POST['firstname'] ?? '';
    $lotBlk = $_POST['lot_blk'] ?? '';
    $street = $_POST['street'] ?? '';
    $phaseSubdivision = $_POST['phase_subdivision'] ?? '';
    $contactNumber = $_POST['contact'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $repeatPassword = $_POST['re_password'] ?? '';

    // Validate required fields
    if (empty($lastName) || empty($firstName) || empty($email) || empty($password) || empty($repeatPassword) || empty($lotBlk) || empty($street) || empty($phaseSubdivision) || empty($contactNumber)) {
        array_push($errors, "All fields are required");
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }

    // Validate password length
    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }

    // Check if passwords match
    if ($password !== $repeatPassword) {
        array_push($errors, "Passwords do not match");
    }

    // Validate contact number format (example: expect 10 digits)
    if (!preg_match('/^[0-9]{11}$/', $contactNumber)) {
        array_push($errors, "Invalid contact number; must be 11 digits");
    }

    // If there are no errors, proceed with inserting the data into the database
    if (count($errors) == 0) {
        // Prepare an insert statement using MySQLi
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encrypt the password before saving in the database
        $stmt = $conn->prepare("INSERT INTO users (lastname, firstname, lot_blk, street, phase_subdivision, contact, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssssssss", $lastName, $firstName, $lotBlk, $street, $phaseSubdivision, $contactNumber, $email, $hashed_password);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page or success page
            header("Location: https://odoruame.000webhostapp.com/Login%20Form/login.php");
            exit();
        } else {
            array_push($errors, "Error: " . $stmt->error);
        }

        // Close statement
        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registration Form</title>
    <link
      rel="stylesheet"
      href="fonts/material-icon/css/material-design-iconic-font.min.css"
    />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div class="main">
      <section class="signup">
        <div class="container">
          <div class="signup-content">
            <form action="register.php" method="POST" id="signup-form" class="signup-form">
              <h2 class="form-title">Create account</h2>
              <div class="form-group">
                <input
                  type="text"
                  class="form-input"
                  name="lastname"
                  id="lastname"
                  placeholder="Last Name"
                  required
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-input"
                  name="firstname"
                  id="firstname"
                  placeholder="First Name"
                  required
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-input"
                  name="lot_blk"
                  id="lot_blk"
                  placeholder="Lot/BLK"
                  required
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-input"
                  name="street"
                  id="street"
                  placeholder="Street"
                  required
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-input"
                  name="phase_subdivision"
                  id="phase_subdivision"
                  placeholder="Phase/Subdivision"
                  required
                />
              </div>
              <div class="form-group">
                <td><select class="form-input" id="barangay"></select></td>
                <br /><br />
                <td><select class="form-input" id="city"></select></td>
                <br /><br />
                <td><select class="form-input" id="province"></select></td>
                <br /><br />
                <td><select class="form-input" id="region"></select></td>
              </div>

              <div class="form-group">
                <input
                  type="tel"
                  class="form-input"
                  name="contact"
                  id="contact"
                  placeholder="Contact Number"
                  required
                />
              </div>
              <div class="form-group">
                <input
                  type="email"
                  class="form-input"
                  name="email"
                  id="email"
                  placeholder="Email Address"
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-input"
                  name="password"
                  id="password"
                  placeholder="Password"
                />
                <span
                  toggle="#password"
                  class="zmdi zmdi-eye field-icon toggle-password"
                ></span>
              </div>
              <div class="form-group">
                <input
                  type="password"
                  class="form-input"
                  name="re_password"
                  id="re_password"
                  placeholder="Repeat your password"
                />
              </div>
              <div class="form-group">
                <input
                  type="checkbox"
                  name="agree-term"
                  id="agree-term"
                  class="agree-term"
                />
              </div>
              <div class="form-group">
                <input
                  type="submit"
                  name="submit"
                  id="submit"
                  class="form-submit"
                  value="Sign up"
                />
              </div>
            </form>
            <p class="loginhere">
              Have already an account ?
              <a href="https://odoruame.000webhostapp.com/Login%20Form/login.php" class="loginhere-link"
                >Login here</a
              >
            </p>
          </div>
        </div>
      </section>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/register.js"></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"
    ></script>
    <script type="text/javascript" src="api/jquery.ph-locations.js"></script>
    <script type="text/javascript">
      var my_handlers = {
        fill_provinces: function () {
          var region_code = $("option:selected", this).data("psgc-code");
          $("#barangay").ph_locations("fetch_list", [
            { region_code: region_code },
          ]);
        },

        fill_cities: function () {
          var province_code = $("option:selected", this).data("psgc-code");
          $("#city").ph_locations("fetch_list", [
            { province_code: province_code },
          ]);
        },

        fill_barangays: function () {
          var city_code = $("option:selected", this).data("psgc-code");
          $("#province").ph_locations("fetch_list", [{ city_code: city_code }]);
        },
      };

      $(function () {
        $("#city").on("change", my_handlers.fill_barangays);
        $("#province").on("change", my_handlers.fill_cities);
        $("#region").on("change", my_handlers.fill_provinces);

        $("#barangay").ph_locations({ location_type: "barangays" });
        $("#city").ph_locations({ location_type: "cities" });
        $("#province").ph_locations({ location_type: "provinces" });
        $("#region").ph_locations({ location_type: "regions" });

        $("#barangay").ph_locations("fetch_list", [
          { selected_value: "PHILIPPINES" },  
        ]);
        $("#city").ph_locations("fetch_list", [
          { selected_value: "PHILIPPINES" },
        ]);
        $("#province").ph_locations("fetch_list", [
          { selected_value: "PHILIPPINES" },
        ]);
        $("#region").ph_locations("fetch_list", [
          { selected_value: "PHILIPPINES" },
        ]);
      });
    </script>
    <script src="api/jquery.ph-locations-v1.0.3.js"></script>
  </body>
</html>