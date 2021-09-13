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
//This code section Use for Upload course information

function test_input($form_data){
    $form_data = stripslashes($form_data);
    $form_data = htmlspecialchars($form_data);
    return $form_data;

}

if(isset($_POST["courseSubmit"])){
    $courseName = $courseCategory = $courseDescription =$courseDuration =$success_1 = $fileName  = $file_upload_stat= "";


    //generate unique Course ID
    $four_digit_rand = "CD".mt_rand(10000, 99999);


    while(1){    

        $sql = "SELECT * FROM course WHERE courseId like '%$four_digit_rand%'";
        $query_result = $conn->query($sql);

        if ($query_result->num_rows == 0) {
            $courseId = $four_digit_rand;
            break;

        } else{
            $four_digit_rand = "ST".mt_rand(1000, 9999);

        }


    }




    //courseName
    if(!empty($_POST["courseName"])){
        $courseName=test_input($_POST["courseName"]);

    }


    //course Category
    if(!empty($_POST["courseCategory"])){
        $courseCategory=$_POST["courseCategory"];
    }

    //course description
    if(!empty($_POST["courseDescription"])){
        $courseDescription = test_input($_POST["courseDescription"]);

    }

    //course duration

    if(!empty($_POST["courseDuration"])){
        $courseDuration = $_POST["courseDuration"];

    }

    //course Cover photo

    if (!empty($_FILES["file"]["name"])) {

        $targetDir = "uploads/Images/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir.$fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);


        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $file_upload_stat = "The file " . $fileName . " has been uploaded successfully.";
                // echo $file_upload_stat;
            } else {
                $file_upload_stat = "Sorry, there was an error uploading your file.";
            }
        } else {
            $file_upload_stat = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    } else {
        $file_upload_stat = 'Please select a file to upload*';
    }


    //add data to database
    //store data
    if($courseName && $courseCategory && $courseDescription && $courseDuration && $fileName){

        $sql = "INSERT INTO course values('$courseId','$courseName','$courseCategory','$courseDescription','$courseDuration','$fileName','$teacherId')";

        $courseName = $courseCategory = $courseDescription =$courseDuration = "";
        $success_1 = "Item added successfully";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['status'] = "Create New Course Successfully";
        } else{
            $_SESSION['erStatus'];
        }





    }}


//update course select

if(isset($_POST['update'])){


    $_SESSION["courseIdUpdate"] = $_POST["courseIdVideo"];
    header("Location:Teacher_Update_Course.php");


}
?>



?>

<?php 
//This code section Use for Upload course Videos
if(isset($_POST["addVideo"])){
    $videoNumber = $videoTitle = $uploadVideo  = $courseIdVideo="";

    //videoNumber
    if(!empty($_POST["videoNumber"])){
        $videoNumber=$_POST["videoNumber"];

    } 

    //videoTitle

    if(!empty($_POST["videoTitle"])){
        $videoTitle = test_input($_POST["videoTitle"]);

    }
    if(!empty($_POST["courseIdVideo"])){
        $courseIdVideo = test_input($_POST["courseIdVideo"]);


    }

    //courseVideo


    $name= $_FILES['file']['name'];

    $tmp_name= $_FILES['file']['tmp_name'];



    $position= strpos($name, ".");

    $fileextension= substr($name, $position + 1);

    $fileextension= strtolower($fileextension);


    if (isset($name)) {

        $path= 'uploads/';
        if (empty($name))
        {
            echo "Please choose a file";
        }
        else if (!empty($name)){
            if (($fileextension !== "mp4") && ($fileextension !== "ogg") && ($fileextension !== "webm"))
            {
                echo "The file extension must be .mp4, .ogg, or .webm in order to be uploaded";
            }


            else if (($fileextension == "mp4") || ($fileextension == "ogg") || ($fileextension == "webm"))
            {
                if (move_uploaded_file($tmp_name, $path.$name)) {
                    //add data to database


                    $sql = "INSERT INTO courseVideo values('','$courseIdVideo','$videoNumber','$videoTitle','$name','ACTIVE')";

                    $courseName = $courseCategory = $courseDescription =$courseDuration = "";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['status'] = "Create New Course Successfully";
                    } else{
                        $_SESSION['erStatus'];
                    }
                }
            }
        }
    }








}









?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>add Course</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/addCourse.css" type="text/css">
    </head>
    <body>

        <?php require("sideBar.php") ?> 


        <div class="courseBody">
            <?php 


    if(isset($_SESSION['status']))
    {
            ?>
            <div>
                <strong style="color: #270; background-color: #DFF2BF;font-size:20px;padding: 15px;">
                    Data Added Successfully !</strong> 
            </div>
            <?php 
        unset($_SESSION['status']);
    }?>



            <h1>Create New Course</h1>

            <form action="addCourse.php" method="post" enctype="multipart/form-data">
                <label for="courseName">Course name:</label>
                <input type="text" name="courseName" required><br>
                <label for="courseCategory">Course Category:</label>


                <select name="courseCategory">
                    <option value="Advanced Level">Advanced Level</option>
                    <option value="Ordinary Level">Ordinary Level</option>
                    <option value="Certificate">Professional certificate</option>

                </select>
                <br>
                <label for="courseDescription">Course Description:</label> <br>
                <textarea rows="10" cols="150" name ="courseDescription" required> </textarea>
                <br>

                <label for="courseDuration">Course Duration:</label>
                <select name="courseDuration" required>
                    <option value="6 Months">Six Months</option>
                    <option value="3 Months">Three Months</option>
                    <option value="1 Month">One Months</option>
                    <option value="Unlimited">Unlimited</option>

                </select>
                <br>

                <label for="coverPhoto">Course Image</label>
                <input type="file" name="file"  >
                <br>
                <input type="submit" name="courseSubmit" value="Create New Course">
            </form> 



            <br>
            <h1>Upload Course Video</h1>

            <form action="addCourse.php" method="post" enctype="multipart/form-data">

                <label for="CourseName">Course Name :</label>

                <?php 
                require('courseNames.php');            
                ?>
                <br>

                <label for="videoNumber">Video Number :</label>

                <input type="number" name="videoNumber"  > <br> 

                <label for="videoTitle">video Title :</label>
                <input type="text" name="videoTitle" required> <br> 

                <label for="uploadVideo" >Upload Video</label>
                <input type="file" name="file"  >
                <br>

                <input type="submit" value="Add Video" name="addVideo">

            </form> 
            
            <h1>Update Course </h1>
             <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            select Course:
            <?php require('courseNames.php')?>
            <input type="submit" name="update" value = "Update Course">

        </form>


        </div>

    </body>
</html>
