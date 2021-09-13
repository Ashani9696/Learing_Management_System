<?php
    require ("config.php");

    $first_name = $last_name = $qualification = $contact_number = $email = $password = $retype_password = "";
    $password_error = $registration_error = "";

    if (isset($_POST["submit"])) {
        function test_input($form_data) {
            $form_data = stripslashes($form_data);
            $form_data = htmlspecialchars($form_data);
            return $form_data;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // First name
            if (isset($_POST["first_name"])) {
                $first_name = test_input($_POST["first_name"]);
            }
            
            // Last name
            if (isset($_POST["last_name"])) {
                $last_name = test_input($_POST["last_name"]);
            }

            // Qualification
            if (isset($_POST["qualification"])) {
                $qualification = test_input($_POST["qualification"]);
            }

            // Contact number
            if (isset($_POST["contact_number"])) {
                $contact_number = test_input($_POST["contact_number"]);
            }

            // Email
            if (isset($_POST["email"])) {
                $email = test_input($_POST["email"]);
            }

            // Password
            if (isset($_POST["password"])) {
                $password = test_input($_POST["password"]);
            }

            // Re-Type password
            if (isset($_POST["retype_password"])) {
                $retype_password = test_input($_POST["retype_password"]);
            }

            if ($password == $retype_password) {
                if ($first_name && $last_name && $qualification && $contact_number && $email && $password && $retype_password) {
                    $sql = "SELECT * FROM teacher WHERE email = '$email'";
                    $query_result = $conn->query($sql);

                    if ($query_result->num_rows == 0) {
                        $test_id = "TC".mt_rand(10000, 99999);

                        while (1) {
                            $sql = "SELECT * FROM teacher WHERE teacherId = '$test_id'";
                            $query_result = $conn->query($sql);

                            if ($query_result->num_rows == 0) {
                                $teacher_id = $test_id;
                                break;
                            } else {
                                $test_id = "TC".mt_rand(10000, 99999);
                            }
                        }

                        $sql = "INSERT INTO teacher VALUES ('$teacher_id', '$first_name', '$last_name', '$email', '$qualification', '$password', '$contact_number')";
                        $query_result = $conn->query($sql);

                        if ($query_result) {
                            header("Location:login.php");
                        } else {
                            $registration_error = "Registration Failed";
                        }
                    } else {
                        $registration_error = "User Already Exists";
                    }
                    
                } else {
                    $registration_error = "Registration Failed";
                }
                
            } else {
                $password_error = "Passwords Don't Match";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="styles/Teacher_Registration.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Details</title>
    </head>
    <body>
        <?php require("sideBar.php") ?>
        <title>Teacher Registration</title>
        <div class="container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1>Register</h1>
            <p><?php echo $invalid_user_error ?></p>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required><br>
            <input type="text" name="qualification" placeholder="Qualification" required><br>
            <input type="text" name="contact_number" placeholder="Phone Number" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <p><?php echo $email_error ?></p>
            <input type="password" name="password" placeholder="Password" required><br>
            <p><?php echo $password_error ?></p>
            <input type="password" name="retype_password" placeholder="Re-Type Password" required><br>
            <input type="submit" name="submit" value="Register">
        </form>
        </div>
    </body>
</html>
