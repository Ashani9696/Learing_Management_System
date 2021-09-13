<?php
require ("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$student_id = $_SESSION["id"];

$current_password = $new_password = $retype_new_password = "";
$current_password_error = $new_password_error = $retype_new_password_error = $update_error = "";

if (isset($_POST["submit"])) {
    function test_input($form_data) {
        $form_data = stripslashes($form_data);
        $form_data = htmlspecialchars($form_data);
        return $form_data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Current Password
        if (isset($_POST["current_password"])) {
            $current_password = test_input($_POST["current_password"]);
        }

        // New Password
        if (isset($_POST["new_password"])) {
            $new_password = test_input($_POST["new_password"]);
        }

        // Re-Type new password
        if (isset($_POST["retype_new_password"])) {
            $retype_new_password = test_input($_POST["retype_new_password"]);
        }

        if ($current_password && $new_password && $retype_new_password) {
            if ($new_password == $retype_new_password) {
                $sql = "SELECT * FROM student WHERE studentId = '$student_id' AND password = '$current_password'";
                $query_result = $conn->query($sql);

                if ($query_result->num_rows == 1) {
                    $sql = "UPDATE student SET password = '$new_password' WHERE studentId = '$student_id' AND password = '$current_password'";
                    $query_result = $conn->query($sql);

                    if ($query_result) {
                        header("Location:Student_Profile.php");
                    } else {
                        $update_error = "Update Failed";
                    }

                } else {
                    $update_error = "User Doesn't Exist";
                }

            } else {
                $update_error = "New Password and Re-Type New Password Doesn't match";
            }

        } else {
            $update_error = "Missing Fields";
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
        <link rel="stylesheet" href="styles/Update_Password.css">
        <title>Update Password</title>
    </head>
    <body>
        <?php require("header.php") ?>

        <div class="container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Update Password</h1>
                <table>
                    <tr>
                        <td><label for="current_password">Current Password: </label></td>
                        <td><input type="password" name="current_password" required><br></td>
                    </tr>
                    <tr>
                        <td><label for="new_password">New Password: </label></td>
                        <td><input type="password" name="new_password" required><br></td>
                    </tr>
                    <tr>
                        <td><label for="retype_new_password">Re-Type New Password: &nbsp;&nbsp;</label></td>
                        <td><input type="password" name="retype_new_password" required><br></td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Update">
                <a href="Student_Profile.php"><input type="button" value="Exit"></a>
            </form>
        </div>
                <?php require("footer.php") ?>

    </body>
</html>