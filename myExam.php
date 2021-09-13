<?php
require("config.php");


session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


$studentId = $_SESSION["id"];
$courseId = $_SESSION["courseId"]

?>

<?php 
//this code section use fetch exam data

    $sql = "select * from exam x,enroll e,course c where e.studentId_fk = '$studentId' and x.courseId_fk = '$courseId' and e.courseId_fk = '$courseId' and c.courseId = '$courseId'";
$paper_arr = $conn->query($sql);

?>


<?php 

//this code section use fetch exam paper
if(isset($_POST['viewPaper'])){

    $paperName = $_POST['paperName'];

    $select = "SELECT * FROM exam where examPaper = '$paperName' ";
    $result = $conn->query($select);

    while($row2 = $result->fetch_object()){

        $pdf = $row2->examPaper;
        $path = 'uploads/papers/';

    }
}
?>

<?php 


//this code section use for upload Answers
if(isset($_POST['answers'])){

    $examId = $_POST['examId'];
    
    //answer uploaded Time
    $time = date("Y-m-d h-i-s");
    
    //answer pdf upload


    $name= $_FILES['file']['name'];

    $tmp_name= $_FILES['file']['tmp_name'];



    $position= strpos($name, ".");

    $fileextension= substr($name, $position + 1);

    $fileextension= strtolower($fileextension);


    if (isset($name)) {

        $path= 'uploads/answers/';
        if (empty($name))
        {
            echo "Please choose a file";
        }
        else if (!empty($name)){
            if (($fileextension !== "pdf") && ($fileextension !== "docx") && ($fileextension !== "doc"))
            {
                echo "The file extension must be .pdf or .docx in order to be uploaded";
            }


            else if (($fileextension == "pdf") || ($fileextension == "docx") || ($fileextension == "doc"))
            {
                if (move_uploaded_file($tmp_name, $path.$name)) {
                    //add data to database
                    if($examId && $time){

                        $sql = "INSERT INTO answers values('$studentId','$name','$time','$examId','$courseId')";

                    }
                    if ($conn->query($sql) === TRUE) {
                       header("location: myCourses.php");
                    } 
                }
            }
        }
    }
    
    

    
    }




?>


.
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My Exam</title>
        <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="styles/myExam.css">
    </head>

    <body>
        <?php require('header.php') ?>

        <?php while ($row = $paper_arr->fetch_assoc()) {?>
        <div class="examBody">

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

                <p>Course Name : <?php echo $row['courseName'];?></p>
                <p>Student ID : <?php echo $studentId;?></p>
                <p>Start Time : <?php echo $row['startTime'];?></p>
                <p>End Time : <?php echo $row['endTime'];?></p>
                <p>Paper : <?php echo $row['examPaper'];?></p>
                <p>Guidelines : <?php echo $row['examDescription'];?></p>

                <input type="hidden" name="paperName" value="<?php echo $row['examPaper'];?>">
                <input type="submit" name="viewPaper" value="View Paper">
                <br>
                <br>
                <input type="hidden" name="examId" value="<?php echo $row['examId'];?>">
                <input type="file" name="file">
                <input type="submit" name="answers" value="Upload Answers">

            </form>


        </div>
        <?php } ?>

        <iframe src="<?php echo $path.$pdf; ?>" width="100%" height="100%"></iframe> 
    </body>
    <?php require("footer.php") ?>
</html>
