<html>
<header>
    <style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,700');
@import url('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');


.sidebar {
  width: 240px;
  height: 160%;
  background: #00003E;
  position: absolute;
 z-index: 100;
 margin-left: -10px;
    margin-top: -60px;
    margin-right: 10px;
}
.sidebar #leftside-navigation ul,
.sidebar #leftside-navigation ul ul {
  margin: -2px 0 0;
  padding: 0;
}
.sidebar #leftside-navigation ul li {
  list-style-type: none;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
.sidebar #leftside-navigation ul li.active > a {
  color: #1abc9c;
}
.sidebar #leftside-navigation ul li.active ul {
  display: block;
}
.sidebar #leftside-navigation ul li a {
  color: white;
  text-decoration: none;
  display: block;
  padding: 30px 0 18px 25px;
  font-size: 18px;
  outline: 0;
 
}
.sidebar #leftside-navigation ul li a:hover {
  color: #1abc9c;
}
.sidebar #leftside-navigation ul li a span {
  display: inline-block;
}
.sidebar #leftside-navigation ul li a i {
  width: 20px;
}

    
    </style>
</header>
    
    <aside class="sidebar">
  <div id="leftside-navigation" class="nano">
    <ul class="nano-content">
      <li class="sub-menu active">
        <a href="#"><i class="fa fa-dashboard"></i><span><h3>Teacher Dashboard</h3></span></a>
      </li>
        <li class="sub-menu">
        <a href="#"><span>Teacher Id : <?php echo $_SESSION["id"]; ?></span></a>
      </li>
      <li class="sub-menu">
        <a href="courseSummary.php"><i class="fa fa-bar-chart-o"></i><span>Summary </span><i class="arrow fa fa-angle-right pull-right"></i></a>
        
      </li>
      <li class="sub-menu">
        <a href="addCourse.php"><i class="fa fa-cogs "></i><span>Course Management</span><i class="arrow fa fa-angle-right pull-right"></i></a>
        
      </li>
      <li class="sub-menu">
        <a href="addExam.php"><i class="fa fa-cogs "></i><span>Exam Management</span><i class="arrow fa fa-angle-right pull-right"></i></a>
        
      </li>
      <li class="sub-menu">
        <a href="examEvaluationSelect.php"><i class="fa fa-certificate"></i><span>Exam Evaluation</span><i class="arrow fa fa-angle-right pull-right"></i></a>
        
      </li>
      <li class="sub-menu">
        <a href="Teacher_Profile.php"><i class="fa fa-user"></i><span>Teacher Profile</span><i class="arrow fa fa-angle-right pull-right"></i></a>
          <br><br>
    <li class="sub-menu">
        <a href="login.php"><i class="fa fa-sign-out"></i><span>Log Out</span></a>
       
        </li>
      
    </ul>
  </div>
</aside>
    
</html>