<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;



}

$courseId = $_SESSION["viewCourseByid"];

?>


<?php


$sql = "SELECT * FROM courseVideo WHERE courseId_fk = '$courseId'";
$myCourse = $conn->query($sql);

//update course video status when user click completed
if (isset($_POST["completed"])) {

    $videoCount = $_POST["showCourseByNumber"];

    $sql2 =" UPDATE courseVideo SET status='COMPLETED' WHERE videoCount=$videoCount";
    $updateStatus = $conn->query($sql2);


}

//Exams
if (isset($_POST["showExam"])) {

    $_SESSION["courseId"] = $courseId;

    header("Location:myExam.php");

}


//Course progressing precentage

error_reporting(0);
$sql3 = "SELECT count(videoCount) FROM courseVideo WHERE status = 'COMPLETED' and courseId_fk = '$courseId' ";
$sql4 = "SELECT count(videoCount) FROM courseVideo where courseId_fk = '$courseId' ";
$check_precentage = $conn->query($sql3);
$check_precentage2 = $conn->query($sql4);
while ($row = $check_precentage->fetch_assoc()) {
    $completed = $row['count(videoCount)'];
}
while ($row = $check_precentage2->fetch_assoc()) {
    $all = $row['count(videoCount)'];
}

$precentage = $completed*100/$all;

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Study</title>
        <meta charset="utf-8">
       <link rel="stylesheet" type="text/css" href="styles/singleMycourseView.css">
    </head>
    <body>
        <?php require('header.php') ?>

        <div class="rectangle"><br>Progress : <?php echo $precentage." % completed"?></div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <input type="submit" name="showExam" value = "Course Exams" id="courseExam">


        </form>


        <?php
        while ($row = $myCourse->fetch_assoc()) {
            $videoCount = $row["videoCount"];
            $x=$row["courseVideo"];
        ?>
        <div class="singleMyCourseView">

            <br>
            <p>Video Number : <?php echo $row["videoNumber"] ?></p>
            <p>Video Title : <?php echo $row["videoTitle"] ?></p>
            <video width="800" height="316" controls>

                <source src="uploads/<?php  echo $x ?>" >
                <br>


            </video>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


                <input type="hidden" name="showCourseByNumber" value="<?php echo $row["videoCount"]; ?>">


                <input type="text"  value="Progress: <?php echo $row["status"] ?>" readonly>
                <input type="submit" name="completed" value="Next Video">


            </form>
            <br>

        </div>
        <?php } ?>

        <a href="myCourses.php">Back to My Course</a>

    </body>
    <?php require("footer.php") ?>
</html>