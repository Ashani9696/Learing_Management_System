<?php
require ("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$course_id = $_SESSION["courseIdUpdate"];

$teacher_id = $_SESSION["id"];

$course_name = $course_description = $course_duration = "";
$db_course_name = $db_course_description = $db_course_duration =$status = "";

$sql = "SELECT * FROM course WHERE courseId = '$course_id' AND teacherId_fk = '$teacher_id'";
$query_result = $conn->query($sql);

if($query_result->num_rows == 1) {
    while($query_result_row = $query_result->fetch_assoc()) {
        $db_course_name = $query_result_row["courseName"];
        $db_course_description = $query_result_row["couseDescription"];
        $db_course_category = $query_result_row["courseCategory"];
        $db_course_duration =$query_result_row["courseDuration"];
    }
}

if (isset($_POST["submit"])) {
    function test_input($form_data) {
        $form_data = stripslashes($form_data);
        $form_data = htmlspecialchars($form_data);
        return $form_data;
    }

    // Course name
    if (empty($_POST["course_name"])) {
        $course_name = $db_course_name;
    } else {
        $course_name = test_input($_POST["course_name"]);
    }

    // Course description
    if (empty($_POST["course_description"])) {
        $course_description = $db_course_description;
    } else {
        $course_description = test_input($_POST["course_description"]);
    }



    if ($course_id && $course_name && $course_description) {
        $sql = "UPDATE course SET courseName = '$course_name', couseDescription = '$course_description' WHERE courseId = '$course_id' AND teacherId_fk = '$teacher_id'";
        $query_result = $conn->query($sql);

        if ($query_result) {

            header("Location:addCourse.php");            } 
        else {
            echo "Update Failed";
        }  
    }
}

if (isset($_POST["exit"])) {
    header("Location:addCourse.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/Teacher_Update_Course.css" type="text/css">

        <title>Document</title>
    </head>
    <body>
        <div class="container">
            <h1>Update Course</h1>
            <table id="table1">
                <tr>
                    <td id="td1">Course ID</td>
                    <td id="td2">:&nbsp;&nbsp;<?php echo $course_id ?></td>
                </tr>
                <tr>
                    <td id="td1">Course Name</td>
                    <td id="td2">:&nbsp;&nbsp;<?php echo $db_course_name ?></td>
                </tr>
                <tr>
                    <td id="td1">Category</td>
                    <td id="td2">:&nbsp;&nbsp;<?php echo $db_course_category ?></td>
                </tr>
                <tr>
                    <td id="td1">Description</td>
                    <td id="td2">:&nbsp;&nbsp;<?php echo $db_course_description ?></td>
                </tr>
                <tr>
                    <td id="td1">Duration</td>
                    <td id="td2">:&nbsp;&nbsp;<?php echo $db_course_duration ?></td>
                </tr>
                <br>
            </table>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <table>
                    <tr>
                        <td><label for="course_name">Course Name&nbsp;</label></td>
                        <td><input type="text" name="course_name"></td>
                    </tr>
                    <tr>
                        <td><label for="course_description">Description</label></td>
                        <td><input type="text" name="course_description" rows="5" columns="600"></td>
                    </tr>

                </table>
                <input type="submit" name="submit" value="Update">
                <input type="submit" name="exit" value="Exit">
            </form>
        </div>
    </body>
</html>

