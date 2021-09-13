<?php
    require ("config.php");

    $email = $user_Type = $password = "";
    $login_error = "";

    if (isset($_POST["login_submit"])) {
        function test_input($form_data) {
            $form_data = stripslashes($form_data);
            $form_data = htmlspecialchars($form_data);
            return $form_data;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Email
            if (isset($_POST["email"])) {
                $email = test_input($_POST["email"]);
                                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $login_error = "Invalid email";
                }
            }

            //Password
            if (isset($_POST["password"])) {
                $password = test_input($_POST["password"]);
            }
            
            //User Type
            if (isset($_POST["user_type"])) {
                $user_type = test_input($_POST["user_type"]);
            }

            if ($email && $user_type && $password) {
                if ($user_type == "teacher") {
    
                    $sql = "SELECT * FROM  teacher  WHERE email = '$email'";
                    $password_db = "password";
                    $user_type_db = "teacher";
                    
                }
                else if ($user_type == "student") {
    
                    $sql = "SELECT * FROM  student  WHERE email = '$email'";
                    $password_db = "password";
                    $user_type_db = "student";
                }
    
                $login_result = $conn->query($sql);
    
                if ($login_result->num_rows > 0) {
                    while ($login_result_row = $login_result->fetch_assoc()) {
                        if ($password == $login_result_row[$password_db]) {
                            if ($user_type_db == "teacher") {
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $login_result_row["teacherId"];
    
                                header("Location:courseSummary.php");
                                
                            } 
                            else if ($user_type_db == "student") {
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $login_result_row["studentId"];
                                
                                header("Location:coursesHome.php");
                            }
                        } else {
                            $login_error = "Inocrrect Email or Password. PLease try again";
                        }
                    }
                } else {
                    $login_error = "User does not exist";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles/Login.css">
    </head>
    <body>
        <div class="container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required style="margin-top: 50px;"><br>

                <input type="password" name="password" placeholder="Password" required><br><br>
                <p><?php echo $login_error ?></p>
                <input type="radio" name="user_type" value="teacher" <?php if (isset($user_type) && $user_type == "teacher") {echo "checked";} ?> required>Teacher
                <input type="radio" name="user_type" value="student" <?php if (isset($user_type) && $user_type == "student") {echo "checked";} ?> required>Student
                <br>
                <input type="submit" value="Login" name="login_submit">
            </form>
        </div>
    </body>
</html>