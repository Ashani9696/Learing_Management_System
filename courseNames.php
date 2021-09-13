<?php 

//fetch course names and course id for video uploading purpose
require("config.php");



$teacherId = $_SESSION["id"];

$sql = "SELECT courseName,courseId From course where teacherId_fk = '$teacherId'";
$courseNames = $conn->query($sql);

if ($courseNames->num_rows > 0) {
    // output data of each row
    echo "<select name='courseIdVideo'>";
    while($row = $courseNames->fetch_assoc()) {
    
    echo "<option value='". $row['courseId'] ."'>" .$row['courseName'] ."</option>";  
        // displaying data in option menu
        
    }
    echo "</select>";
} else {
    echo "0 results";
}
$conn->close();

?>

