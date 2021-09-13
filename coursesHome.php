<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$sortType ="";

if (isset($_POST["sorting"])) {

    if (!empty($_POST["sorting"])) {

        $sortType = $_POST["sort"];

    }


}

if($sortType == 'duration'){

    $sql = "SELECT * FROM course where courseCategory='Advanced Level' order by courseDuration DESC";
    $sql2 = "SELECT * FROM course where courseCategory='Ordinary Level' order by courseDuration DESC";
    $sql3 = "SELECT * FROM course where courseCategory='Certificate' order by courseDuration DESC";


    $course_arr = $conn->query($sql);    
    $course_arr2 = $conn->query($sql2);
    $course_arr3 = $conn->query($sql3);


    if (isset($_POST["viewCourse"])) {



        $_SESSION["showCourseById"] = $_POST["showCourseById"];
        $_SESSION["showCourseDuration"] = $_POST["showCourseDuration"];

        header("Location:singleCourseView.php");

    }}

else{
    $sql = "SELECT * FROM course where courseCategory='Advanced Level' order by courseId DESC";
    $sql2 = "SELECT * FROM course where courseCategory='Ordinary Level' order by courseId DESC";
    $sql3 = "SELECT * FROM course where courseCategory='Certificate' order by courseId DESC";

    $course_arr = $conn->query($sql);
    $course_arr2 = $conn->query($sql2);
    $course_arr3 = $conn->query($sql3);

    if (isset($_POST["viewCourse"])) {



        $_SESSION["showCourseById"] = $_POST["showCourseById"];
        $_SESSION["showCourseDuration"] = $_POST["showCourseDuration"];

        header("Location:singleCourseView.php");
    }}




?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <title>All Courses</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/coursesHome.css" type="text/css" >
                <link rel="stylesheet" href="styles/studentCommon.css" type="text/css" >

    </head>
    <body>
        
<?php require('header.php') ?>
        <div class="courses">


            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


                <input type="radio" id="contactChoice1"  name="sort" value="latest" checked>
                <label for="contactChoice1">Latest</label>

                <input type="radio" id="contactChoice2" name="sort" value="duration">
                <label for="contactChoice2">Duration</label>

                <input type="submit" value="sort" name="sorting" id="sort">


            </form>
            <h1>Advanced Level</h1>
            <div class = "courses"> 

                <?php while ($row = $course_arr->fetch_assoc()) { ?>
                <div class="courseBuffer">

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="showCourseById" value="<?php echo $row["courseId"]; ?>">
                        <input type="hidden" name="showCourseDuration" value="<?php echo $row["courseDuration"]; ?>">

                        <img src="uploads/Images/<?php  echo $row["coverImage"] ?>" alt="Item-image"  class="coverImage">


                        <p id="courseName"> <?php echo $row["courseName"]; ?> </p>  
                        <p><?php echo $row["courseCategory"]; ?> </p>
                        
                        <p>Course duration : <?php echo $row["courseDuration"]; ?> </p>

                        <input type="submit" value="View Class" name="viewCourse" />
                    </form>


                </div>
                <?php } ?>
            </div>

            <h1>Ordinary Level</h1>
            <div class = "courses"> 

                <?php while ($row = $course_arr2->fetch_assoc()) { ?>
                <div class="courseBuffer" >

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="showCourseById" value="<?php echo $row["courseId"]; ?>">
                        <input type="hidden" name="showCourseDuration" value="<?php echo $row["courseDuration"]; ?>">

                        <img src="uploads/Images/<?php  echo $row["coverImage"] ?>" alt="Item-image" class="coverImage">


                        <p id="courseName"> <?php echo $row["courseName"]; ?> </p>  
                        <p><?php echo $row["courseCategory"]; ?> </p>
                        <p>Course duration : <?php echo $row["courseDuration"]; ?> </p>

                        <input type="submit" value="View Class" name="viewCourse" />
                    </form>


                </div>
                <?php } ?>
            </div>
            <h1>Professional Certificate</h1>
            <div class = "courses"> 

                <?php while ($row = $course_arr3->fetch_assoc()) { ?>
                <div class="courseBuffer" >

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="showCourseById" value="<?php echo $row["courseId"]; ?>">
                        <input type="hidden" name="showCourseDuration" value="<?php echo $row["courseDuration"]; ?>">


                        <img src="uploads/Images/<?php  echo $row["coverImage"] ?>" alt="Item-image"  class="coverImage">


                        <p id="courseName"> <?php echo $row["courseName"]; ?> </p>  
                        <p><?php echo $row["courseCategory"]; ?> </p>
                        <p>Course duration : <?php echo $row["courseDuration"]; ?> </p>

                        <input type="submit" value="View Course" name="viewCourse" />
                    </form>


                </div>
                <?php } ?>
            </div>







        </div>



    </body>
    <?php require("footer.php") ?>
    
</html>
