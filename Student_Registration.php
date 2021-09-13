<?php
    require ("config.php");

    $first_name = $last_name = $contact_number = $email = $password = $retype_password = "";
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
                if ($first_name && $last_name && $contact_number && $email && $password && $retype_password) {
                    $sql = "SELECT * FROM student WHERE email = '$email'";
                    $query_result = $conn->query($sql);
    
                    if ($query_result->num_rows == 0) {
                        $test_id = "ST".mt_rand(10000, 99999);

                        while (1) {
                            $sql = "SELECT * FROM student WHERE studentId = '$test_id'";
                            $query_result = $conn->query($sql);
    
                            if ($query_result->num_rows == 0) {
                                $student_id = $test_id;
                                break;
                            } else {
                                $test_id = "ST".mt_rand(10000, 99999);
                            }
                        }

                        $sql = "INSERT INTO student VALUES ('$student_id', '$first_name', '$last_name', '$email', '$password', '$contact_number')";

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
                $registration_error = "Passwords Don't Match";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
        </title>
        <link rel="stylesheet" href="styles/Student_Registration.css">
    </head>
    <body>
        <title>Student Registration</title>
                <?php require("header.php") ?>

        <div class="container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Register</h1>
                <table>
                    <tr>
                        <td><label for="first_name">First Name: </label></td>
                        <td><input type="text" name="first_name" placeholder="First Name"></td>
                    </tr>
                    <tr>
                        <td><label for="last_name">Last Name: </label></td>
                        <td><input type="text" name="last_name" placeholder="Last Name"><br></td>
                    </tr>
                    <tr>
                        <td><label for="contact_number">Contact Number: &nbsp;&nbsp;</label></td>
                        <td><input type="text" name="contact_number" placeholder="Contact Number"><br></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email: </label></td>
                        <td><input type="email" name="email" placeholder="Email"><br></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password: </label></td>
                        <td><input type="password" name="password" placeholder="password"><br></td>
                    </tr>
                    <tr>
                        <td><label for="retype_password">Retype Password: &nbsp;&nbsp;</label></td>
                        <td><input type="password" name="retype_password" placeholder="Re-Type Password"><br></td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Register"><br>
            </form>  
        </div>
                <?php require("footer.php") ?>

    </body>
</html>