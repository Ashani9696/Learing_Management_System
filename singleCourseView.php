<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;



}

$courseId = $_SESSION["showCourseById"];
$courseDuration = $_SESSION["showCourseDuration"];

//studentID for foreign key
$studentId = $_SESSION["id"];
?>


<?php


$sql = "SELECT * FROM course c,teacher t WHERE c.courseId = '$courseId' and t.teacherId = c.teacherId_fk";
$course = $conn->query($sql);

$sql2 = "SELECT * FROM enroll WHERE courseId_fk = '$courseId' and studentId_fk = '$studentId'";
$courseId_check = $conn->query($sql2);


$today = $endDate = $enrollId = $endingDate =$status= "";
//today date

$today = date("y-m-d");
//course end Date
//check course duration and assign
if(strcmp($courseDuration,"3 Months")== 0){


    $endDate = date('Y-m-d', strtotime($today. ' + 90 days')); 

}

else if(strcmp($courseDuration,"1 Month")== 0){


    $endDate = date('Y-m-d', strtotime($today. ' + 30 days')); 

}

else if(strcmp($courseDuration,"6 Months")== 0){

    $endDate = date('Y-m-d', strtotime($today. ' + 180 days')); 

}


if (isset($_POST["enroll"])) {



    //studentID foreign key
    $studentId = $_SESSION["id"];

    //generate unique enroll ID
    $four_digit_rand = "EN".mt_rand(10000, 99999);


    while(1){    

        $sql = "SELECT * FROM enroll WHERE enrollId like '%$four_digit_rand%'";
        $query_result = $conn->query($sql);

        if ($query_result->num_rows == 0) {
            $enrollId = $four_digit_rand;
            break;

        } else{
            $four_digit_rand = "ST".mt_rand(1000, 9999);

        }


    }

    if($courseId_check->num_rows == 0){

        $sql = "insert into enroll values('$enrollId','$endDate','$today','$studentId','$courseId')";

        if ($conn->query($sql) === TRUE) {
            $status ='<div>
<h4>Enrolled Successfully !<i class="icon fa fa-check"></i></h4>
</div>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }else{

        //already enrolled error 
        $status ='<div>
<h4>Already Enrolled Check Your Course Page ! <i class="icon fa fa-check"></i></h4>
</div>';
    }
}



//delete course access when the course expired\

$sql3 = "SELECT * FROM enroll WHERE enrollId like '%$enrollId%'";
$query_result_delete = $conn->query($sql3);

if ($query_result_delete->num_rows >0 ) {

    while ($row = $query_result_delete->fetch_assoc()) {
        $endingDate = $row["endDate"];

        if($endingDate == $today){
            $sql = "delete * from enroll where enrollId ='$enrolId'";
            $conn->query($sql);
        }

    }
}



?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Enroll Course</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="styles/singleCourseView.css">
                <link rel="stylesheet" href="styles/studentCommon.css" type="text/css" >

    </head>
    <body>


        <?php require('header.php') ?>


        <?php
    while ($row = $course->fetch_assoc()) {
        $teacherId = $row["teacherId_fk"];

        ?>
        <div>
            <div id="singleCourseView">
                 <div>
                <strong style="color:green;font-size:20px" >
                    <?php echo $status ?></strong> 
            </div>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <input type="hidden" name="showCourseById" value="<?php echo $row["courseId"]; ?>">

                    <img src="uploads/Images/<?php  echo $row["coverImage"] ?>" alt="Item-image" id="coverImg" >

                    <p>Course Name : <?php echo $row["courseName"]; ?> </p>
                    <p>Course Category: <?php echo $row["courseCategory"]; ?> </p>
                    <p>Teacher Name : <?php echo $row["firstName"]." ".$row["lastName"]; ?> </p>
                    <p>Teacher Qualification : <?php echo $row["qualification"]; ?> </p>

                    <p id="courseDes">Course Details :<br><?php echo $row["couseDescription"]; ?> </p>
                    <p>Start Date : <?php echo $today; ?> </p>
                    <p>End Date : <?php echo $endDate; ?> </p>

                    <input type="submit" value="ENROLL NOW" name="enroll" id="submitBtn"/>


                </form>
            </div>
            <?php } ?>

            <a href="coursesHome.php">back to Home</a>
        </div>
    </body>
    <?php require("footer.php") ?>
</html>