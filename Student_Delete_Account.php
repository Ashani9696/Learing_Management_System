<?php
    require ("config.php");
    
    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    $password = "";
    $delete_error = "";

    $student_id = $_SESSION["id"];

    if (isset($_POST["submit"])) {
        function test_input($form_data) {
            $form_data = stripslashes($form_data);
            $form_data = htmlspecialchars($form_data);
            return $form_data;
        }

        // Password
        if (isset($_POST["password"])) {
            $password = test_input($_POST["password"]);
        }
        
        if ($password) {
            $sql = "SELECT * FROM student WHERE studentId = '$student_id' AND password = '$password'";
            $query_result = $conn->query($sql);

            if ($query_result->num_rows == 1) {
                $sql = "DELETE FROM student WHERE studentId = '$student_id' AND password = '$password'";
                $query_result = $conn->query($sql);

                if ($query_result) {
                    session_destroy();
                    header("Location:Success.php");
                } else {
                    $delete_error = "Failed to Delete Account";
                }
                
            } else {
                $delete_error = "Invalid Password";
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
        <link rel="stylesheet" href="styles/Delete_Account.css">
        <title>Delete Account</title>
    </head>
    <body>
                <?php require("header.php") ?>

        <div class="container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Delete Account</h1>
                <label for="password">Password</label>
                <input type="password" name="password" required><br><br>
                <input type="checkbox" name="agree" required>
                <label for="agree">I agree to.....</label><br><br>
                <input type="submit" name="submit" value="Delete Account">
                <a href="Student_Profile.php"><input type="button" value="Exit"></a>
            </form>
        </div>
                <?php require("footer.php") ?>

    </body>
</html>