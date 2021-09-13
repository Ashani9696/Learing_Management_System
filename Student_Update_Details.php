<?php
require ("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$student_id = $_SESSION["id"];

$first_name = $last_name = $contact_number = $password = "";
$db_first_name = $db_last_name = $db_contact_number = $db_password = "";
$update_error = "";

if (isset($_POST["submit"])) {
    function test_input($form_data) {
        $form_data = stripslashes($form_data);
        $form_data = htmlspecialchars($form_data);
        return $form_data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "SELECT * FROM student WHERE studentId = '$student_id'";
        $query_result = $conn->query($sql);

        if ($query_result->num_rows == 1) {
            while ($query_result_row = $query_result->fetch_assoc()) {
                $db_first_name = $query_result_row["firstName"];
                $db_last_name = $query_result_row["lastName"];
                $db_contact_number = $query_result_row["contactNumber"];
            }
        } 

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

        // password
        if (isset($_POST["password"])) {
            $password = test_input($_POST["password"]);
        }

        $sql = "SELECT * FROM student WHERE studentId = '$student_id' AND password = '$password'";
        $query_result = $conn->query($sql);

        if ($password) {
            if ($query_result->num_rows == 1) {
                $sql = "UPDATE student SET firstName = '$first_name', lastName = '$last_name', contactNumber = '$contact_number' WHERE studentId = '$student_id' AND password = '$password'";
                $query_result = $conn->query($sql);

                if ($query_result) {
                    header("Location:Student_Profile.php");
                } else {
                    $update_error = "Update Failed";
                }

            } else {
                $update_error = "Incorrect Password";
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
        <?php require("header.php") ?>

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
                        <td><label for="contact_number">Contact Number: &nbsp;&nbsp;</label><br><br><br></td>
                        <td><input type="text" name="contact_number" placeholder="<?php echo $db_contact_number ?>"><br><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password: </label></td>
                        <td><input type="password" name="password" placeholder=""><br></td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Update">
                <a href="Student_Profile.php"><input type="button" value="Exit"></a>
            </form>
        </div>
                <?php require("footer.php") ?>

    </body>
</html>