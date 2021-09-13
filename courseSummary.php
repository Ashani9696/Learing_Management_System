<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


//TeacherId 
$teacherId = $_SESSION["id"];

//
$viewData ="";
//select student count
$sql = "SELECT c.courseId,c.courseName,e.courseId_fk,count(e.studentId_fk) from enroll e,course c where e.courseId_fk = c.courseId and c.teacherId_fk ='$teacherId' group by(e.courseId_fk);";

$course_arr = $conn->query($sql);
$course_arr2 = $conn->query($sql);

if ($course_arr2->num_rows > 0) {
    $row2 = $course_arr2->fetch_assoc();

}


?>

<?php
error_reporting(0);

//this code section use for view Students 
if (isset($_POST["viewStudent"])) {

    $courseId = $_POST["showCourseById"];

    $sql2 ="select s.studentId,s.firstName,s.lastName,e.startDate from student s , enroll e where e.courseId_fk='$courseId' and e.studentId_fk = s.studentId";
    $viewData = $conn->query($sql2);


}

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Course</title>
        <meta charset="utf-8">
<link rel="stylesheet" href="styles/courseSummary.css" type="text/css">
    </head>
   
    <body>

<?php require("sideBar.php") ?> 
        
        
        
        <div class="summaryBody">
            <h1>Student Enrollment Details</h1><br>
            
        <table border="2 " id="mainTable">
            <tr>
                <th>Course Name</th>
                <th>Students</th>
                <th>Action</th>
            </tr>  
            <?php while ($row = $course_arr->fetch_assoc()) { ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="showCourseById" value="<?php echo $row["courseId"]; ?>">

                <tr>

                    <td> <p id="courseName"> <?php echo $row["courseName"]; ?> </p>  </td>

                    <td> <p>Students : <?php echo $row["count(e.studentId_fk)"]; ?> </p></td>

                    <td>  <input type="submit" value="View" name="viewStudent" /></td>
                </tr>   

            </form>



            <?php } ?>

        </table>

        <br>

        <table border="2" style="width:100%" id="mainTable">
            <tr>
                <th>StudentName</th>
                <th>Student Id</th>
                <th>Enroll Date</th>
            </tr>  
            <?php while ($row = $viewData->fetch_assoc()) { ?>



            <tr>

                <td> <p> <?php echo $row["firstName"]." ".$row["lastName"]; ?> </p>  </td>

                <td> <p> <?php echo $row["studentId"]; ?> </p></td>

                <td><p> <?php echo $row["startDate"]; ?></td>
            </tr>   

            

        <?php } ?>

        </table>
            </div>
    </body>
</html>