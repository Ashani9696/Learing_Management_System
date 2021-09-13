
<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

//teacherID for foreign key
$teacherId = $_SESSION["id"];



?>

<?php 



if(isset($_POST['view'])){


    $_SESSION["courseIdExam"] = $_POST["courseIdVideo"];
    header("Location:examEvaluation.php");


}
?>





<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Exam Evaluation Select</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/coursesHome.css" type="text/css" >
        <link rel="stylesheet" href="styles/addCourse.css" type="text/css" >
        

    </head>
    <body>
<?php require("sideBar.php") ?> 

<div class="courseBody" style="padding-top:200px;">


        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php require('courseNames.php')?>
            <input type="submit" name="view" value = "View Answers">

        </form>

</div>


    </body>
</html>