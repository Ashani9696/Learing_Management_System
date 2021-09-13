
<?php
require("config.php");


session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


$teacherId = $_SESSION["id"];

?>

<?php

$startTime = $endTime = $examId =$success = "";

if(isset($_POST["addExam"]))
{
    //generate unique exam id

    $four_digit_rand = "EX".mt_rand(10000, 99999);


    while(1){    

        $sql = "SELECT * FROM exam WHERE examId like '%$four_digit_rand%'";
        $query_result = $conn->query($sql);

        if ($query_result->num_rows == 0) {
            $examId = $four_digit_rand;
            break;

        } else{
            $four_digit_rand = "EX".mt_rand(1000, 9999);

        }


    }

    //exam start Time
    if(!empty($_POST["startTime"])){
        $startTime=$_POST["startTime"];
    }
    //exam end time
    if(!empty($_POST["endTime"])){
        $endTime=$_POST["endTime"];

    }

    //Course Id
    if(!empty($_POST["courseIdVideo"])){
        $courseIdExam = ($_POST["courseIdVideo"]);

    }
    //addtional details
    if(!empty($_POST["details"])){
        $examDescription = ($_POST["details"]);

    }


    //Exam paper pdf



    $name= $_FILES['file']['name'];

    $tmp_name= $_FILES['file']['tmp_name'];



    $position= strpos($name, ".");

    $fileextension= substr($name, $position + 1);

    $fileextension= strtolower($fileextension);


    if (isset($name)) {

        $path= 'uploads/papers/';
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
                    if($startTime && $endTime && $examDescription){

                        $sql = "INSERT INTO exam values('$examId','$name','$startTime','$endTime','$examDescription','$teacherId','$courseIdExam')";

                    }
                    if ($conn->query($sql) === TRUE) {


                        $success ='<div>
<h4>New Exam Added Successfully!<i class="icon fa fa-check"></i></h4>
</div>';

                    } 
                }
            }
        }
    }








}







?>
<?php
//view all exam listed

$sql3 = "select * from exam where teacherId_fk = '$teacherId'";
$exam_list = $conn->query($sql3);


//delete exam 

if(isset($_POST['deleteExam'])){

    $examID = $_POST["showExamById"];

    $sql4 = "delete from exam where examId = '$examID'";
    if($conn->query($sql4)){

    }else{

    }


}


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create Exam</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="styles/addCourse.css">
        <link rel="stylesheet" type="text/css" href="styles/myExam.css">



    </head>
    <body>
        <?php require("sideBar.php") ?>
        <div class="courseBody" >

            <div>
                <strong style="color:green;font-size:20px" >
                    <?php echo $success ?></strong> 
            </div>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                Course Name:
                <?php require("courseNames.php"); ?>

                <br>
                Exam Paper : <input type="file" name="file">
                <br>
                <label for="startTime">Start Time &nbsp; </label>

                <input type="datetime-local" name="startTime" required >
                <br><br>
                <label for="endTime">End Time &nbsp;</label>
                <input type="datetime-local" name="endTime" required >
                <br>
                <br>
                <label for="details">Exam Guideline</label>
                <br>
                <textarea name="details" cols="150" rows="5"></textarea>
                <br>
                <input type="submit" name="addExam" value="Create Exam"> 




            </form>




            <br><br><br>
            <h1>Planned Exam</h1><br>
            <table border="2 " id="mainTable">
                <tr>
                    <th>Exam Id</th>
                    <th>Exam Name</th>
                    <th>Exam Date</th>
                    <th>Action</th>
                </tr>  
                <?php while ($row = $exam_list->fetch_assoc()) { ?>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="showExamById" value="<?php echo $row["examId"]; ?>">

                    <tr>

                        <td> <p > <?php echo $row["examId"]; ?> </p>  </td>

                        <td> <p><?php echo $row["examPaper"]; ?> </p></td>
                        <td> <p><?php echo $row["startTime"]; ?> </p></td>

                        <td>  <input type="submit" value="Delete" name="deleteExam" id="deleteBtn" /></td>
                    </tr>   

                </form>



                <?php } ?>

            </table>     










        </div>





    </body>
</html>