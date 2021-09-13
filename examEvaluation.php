
<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

//teacherID for foreign key
$teacherId = $_SESSION["id"];
$courseIdExam = $_SESSION["courseIdExam"];
$success = "";


?>

<?php 

    $sql = "select * from answers where courseId_fk = '$courseIdExam'";

$result_arr = $conn->query($sql);


?>

<?php 

//this code section use fetch exam paper
if(isset($_POST['viewAnswer'])){

    $examId = $_POST['examID'];
    $examStudentId = $_POST['examStudentId'];


    $paperAnswer = $_POST['paperAnswer'];

    $sql2 = "select answer from answers where examId_fk ='EX40434'";

    $result = $conn->query($sql2);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            $bytes = $row['answer'];

            header("Content-type: application/pdf");
            header('Content-disposition: attachment; filename="answer.pdf"');
            print $bytes;

        }

    }}


//Submit Result
if(isset($_POST['resultSubmit'])){

    $examId = $_POST['examID'];
    $examStudentId = $_POST['examStudentId'];

    $resultExam = $_POST['result'];


    $sql3 = "insert into result values('$examStudentId','$resultExam','$courseIdExam','$examId')";


    if ($conn->query($sql3) === TRUE) {
       $success ='<div>
<h4>Marks Inserted Succesfully!<i class="icon fa fa-check"></i></h4>
</div>';
    } 



}

if(isset($_POST['resultUpdate'])){

    $examId = $_POST['examID'];
    $examStudentId = $_POST['examStudentId'];

    $resultExam = $_POST['result'];


    $sql3 = "UPDATE result SET result ='$resultExam' WHERE teacherId = '$examId'";


    if ($conn->query($sql3) === TRUE) {
       $success ='<div>
<h4>Marks Updated Succesfully!<i class="icon fa fa-check"></i></h4>
</div>';
    } 



}







?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Exam Evaluation</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/coursesHome.css" type="text/css" >
        <link rel="stylesheet" href="styles/courseSummary.css" type="text/css">


    </head>
    <body>




        <?php require("sideBar.php") ?> 

        <div class="summaryBody">
             <div>
                <strong style="color:green;font-size:20px" >
                    <?php echo $success ?></strong> 
            </div>

            
            <table border="2" style="width:100%" id="mainTable">
                <tr>
                    <th>Exam Id </th>
                    <th>Student Id </th>
                    <th>Submit Time </th>
                    <th>Answer</th>

                    <th>Result</th>
                </tr>  
                <?php while ($row = $result_arr->fetch_assoc()) { ?>


                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

                    <tr>

                        <td> <p> <?php echo $row["examId_fk"] ?> </p>  </td>
                        <td> <p> <?php echo $row["studentId_fk"] ?> </p>  </td>

                        <td> <p> <?php echo $row["submitDate"]; ?> </p></td>

                        <td><p> <?php echo $row["answer"]; ?>
                            <input type="hidden" name="examStudentId" value="<?php echo $row["studentId_fk"] ?> " >
                            <input type="hidden" name="examID" value=" <?php echo $row["examId_fk"] ?>  " >
                            <input type="hidden" name="paperAnswer" value=" <?php echo $row["answer"];?>  " >
                            <input type="submit" name="viewAnswer" value="Download">
                        </td>


                        <td><input type="text" name="result" >
                            <input type="submit" name="resultSubmit" value="submit">
                            <input type="submit" name="resultUpdate" value="Update">
                        </td>
                    </tr>   


                </form>

                <?php } ?>

            </table>


        </div>
    </body>
</html>