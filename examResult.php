<?php
require("config.php");


session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>



<?php 
$result =$status ="";
error_reporting(0);
if(isset($_POST['checkResult'])){
    $index = $_POST['resultSearch'];


    $sql = "select * from result r,student s,course c where r.studentId_fk = '$index' and  r.studentId_fk = s.studentId and r.courseId = c.courseId ";

    if($result = $conn->query($sql)){
        
    }else{
        $status = "Invalid Index Number";
    }



}



?>


<!DOCTYPE html>
<html lang="en">
    <head>


        <title>Exam Result</title>
        <meta charset="utf-8">

        <link rel="stylesheet" href="styles/examResult.css" type="text/css" >

        <link rel="stylesheet" href="styles/studentCommon.css" type="text/css" >


    </head>

    <body>

        <?php require('header.php') ?>
        <div class="resultSheet">

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <input type="search" name="resultSearch" placeholder="Student Id Number " id="idNumber">
                <input type="submit" name="checkResult" value="Check Result">

            </form>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <?php echo $status; ?>
            <p>Student Id  : <?php echo $row["studentId"]; ?></p>
            <p>Student Name: <?php echo $row["firstName"]." ".$row["lastName"]; ?></p>

            <p>Course Name : <?php echo $row["courseName"]; ?></p>
            <p>Result : <?php echo $row["result"]; ?></p>
            <hr>


            <?php } ?>
        </div>
    </body>


</html>