<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

//studentID for foreign key
$studentId = $_SESSION["id"];

$sql = "SELECT * from course c,enroll e where e.studentId_fk = '$studentId' and e.courseId_fk = c.courseId ";

$myCourse_array = $conn->query($sql);

if (isset($_POST["studyCourse"])) {

    // echo $_POST["show_item_by_id"];

    $_SESSION["viewCourseByid"] = $_POST["viewCourseByid"];

    header("Location:singleMyCourseView.php");

}

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My Courses</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/coursesHome.css" type="text/css" >
        <link rel="stylesheet" href="styles/myCourses.css" type="text/css" >
        <link rel="stylesheet" href="styles/studentCommon.css" type="text/css" >


    </head>
    <body>

        <?php require('header.php') ?>

        <div class="myCourses">
            <?php while ($row = $myCourse_array->fetch_assoc()) { ?>
            <div class="courseBuffer" >


                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="viewCourseByid" value="<?php echo $row["courseId"]; ?>">

                    <img src="uploads/Images/<?php  echo $row["coverImage"] ?>" alt="Item-image"  class="coverImage">


                    <p id="courseName"> <?php echo $row["courseName"]; ?> </p>  
                    <p id="courseName">End Date : <?php echo $row["endDate"]; ?> </p> 
                    <input type="submit" value="Study Now" name="studyCourse" />
                </form>


            </div>
            <?php } ?>
        </div>

    </body>
    <?php require("footer.php") ?>
</html>