<?php
    require ("config.php");

    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    $first_name = $last_name = $qualification = $contact_number = $password = "";
    $db_first_name = $db_last_name = $db_qualification = $db_contact_number = $db_password = "";
    $update_error = "";

    $teacher_id = $_SESSION["id"];
    
    if (isset($_POST["submit"])) {
        function test_input($form_data) {
            $form_data = stripslashes($form_data);
            $form_data = htmlspecialchars($form_data);
            return $form_data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sql = "SELECT * FROM teacher WHERE teacherId = '$teacher_id'";
                $query_result = $conn->query($sql);

                if ($query_result->num_rows == 1) {
                    while ($query_result_row = $query_result->fetch_assoc()) {
                        $db_first_name = $query_result_row["firstName"];
                        $db_last_name = $query_result_row["lastName"];
                        $db_qualification = $query_result_row["qualification"];
                        $db_contact_number = $query_result_row["contactNumber"];
                    }
                } 

            // First name
            if (empty($_POST["first_name"])) {
                $first_name = $db_first_name;
            } else {
                $first_name = test_input($_POST["first_name"]);
            }

            // Last name
            if (empty($_POST["last_name"])) {
                $last_name = $db_last_name;
            } else {
                $last_name = test_input($_POST["last_name"]);
            }

            // Qualification
            if (empty($_POST["qualification"])) {
                $qualification = $db_qualification;
            } else {
                $qualification = test_input($_POST["qualification"]);
            }

            // Contact number
            if (empty($_POST["contact_number"])) {
                $contact_number = $db_contact_number;
            } else {
                $contact_number = test_input($_POST["contact_number"]);
            }

            // password
            if (empty($_POST["password"])) {
                $password_error = "Password is Required";
            } else {
                $password = test_input($_POST["password"]);
            }

            $sql = "SELECT * FROM teacher WHERE teacherId = '$teacher_id' AND password = '$password'";
            $query_result = $conn->query($sql);

            if ($password) {
                if ($query_result->num_rows == 1) {
                    $sql = "UPDATE teacher SET firstName = '$first_name', lastName = '$last_name', qualification = '$qualification', contactNumber = '$contact_number' WHERE teacherId = '$teacher_id' AND password = '$password'";
                    $query_result = $conn->query($sql);
    
                    if ($query_result) {
                        header("Location:Teacher_Profile.php");
                    } else {
                        $update_error = "Update Failed";
                    }
                    
                } else {
                    $password_error = "Incorrect Password";
                }
            }
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/Update_Details.css">
        <title>Update Details</title>
    </head>
    <body>
        <?php require("sideBar.php") ?>
        <div class="container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Update Details</h1>
                <table>
                    <tr>
                        <td><label for="first_name">First Name: </label></td>
                        <td><input type="text" name="first_name" placeholder="<?php echo $db_first_name ?>"><br></td>
                    </tr>
                    <tr>
                        <td><label for="last_name">Last Name: </label></td>
                        <td><input type="text" name="last_name" placeholder="<?php echo $db_last_name ?>"><br></td>
                    </tr>
                    <tr>
                        <td><label for="qualification">Qualification: </label></td>
                        <td><input type="text" name="qualification" placeholder="<?php echo $qualification ?>"><br></td>
                    </tr>
                    <tr>
                        <td><label for="contact_number">Contact Number:&nbsp;&nbsp;</label><br><br></td>
                        <td><input type="text" name="contact_number" placeholder="<?php echo $db_contact_number ?>"><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password: </label></td>
                        <td><input type="password" name="password" placeholder=""><br></td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Update">
                <a href="Teacher_Profile.php"><input type="button" value="Exit"></a>
            </form>
        </div>
    </body>
</html>