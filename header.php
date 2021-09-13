<!-- Sticky header -->
<html>
    <head>
        <style>

            @import url("https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap");

            *,
            *:after,
            *:before {
                box-sizing: border-box;

            }

            :root {
                --header-outer-height: 110px;
                --header-inner-height: 50px;
                --header-height-difference: calc(
                    var(--header-outer-height) - var(--header-inner-height)
                    );
                --header-bg: #00003E;
            }

            body {

                font-family: "DM Sans", sans-serif;
                background-color: #f2f5f7;
                line-height: 1.5;

                position: relative;
                margin-top: -1px;
                margin-left: -1px;
                margin-right: -1px;

            }

            .responsive-wrapper {
                width: 90%;
                max-width: 1280px;
                margin-left: auto;
                margin-right: auto;
            }

            /* Sticky header */
            .header-outer {
                /* Make it stick */
                height: var(--header-outer-height);
                position: sticky;
                top: calc(
                    var(--header-height-difference) * -1
                ); /* Multiply by -1 to get a negative value */
                display: flex;
                align-items: center;

                /* Other */
                background-color: var(--header-bg);
                box-shadow: 0 2px 10px 0 rgba(0,0,0, 0.1);
            }

            .header-inner {
                /* Make it stick */
                height: var(--header-inner-height);
                position: sticky;
                top: 0;

                /* Other */
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            /* Styling of other elements */
            .header-logo img {
                display: block;
                /*height: calc(var(--header-inner-height) - 30px);*/
                width: 300px;
                height: 200px;
            }

            .header-navigation {
                display: flex;
                flex-wrap: wrap;
            }

            .header-navigation a,
            .header-navigation button {
                font-size: 1.125rem;
                color: inherit;
                margin-left: 1.75rem;
                position: relative;
                font-weight: 500;

            }

            .header-navigation a {
                display: none;
                font-size: 1.125rem;
                color: white;
                text-decoration: none;

            }

            .header-navigation button {
                border: 0;
                background-color: transparent;
                padding: 0;
            }

            .header-navigation a:hover:after,
            .header-navigation button:hover:after {
                transform: scalex(1);
            }

            .header-navigation a:after,
            .header-navigation button:after {
                transition: 0.25s ease;
                content: "";
                display: block;
                width: 100%;
                height: 2px;
                background-color: currentcolor;
                transform: scalex(0);
                position: absolute;
                bottom: -2px;
                left: 0;
            }

            .main {
                margin-top: 3rem;
                margin-left: 30px;

            }
            .avatar {

                width: 30px;
                height: 30px;
                border-radius: 50%;
                margin-left: 20px;

            }

            @media (min-width: 800px) {
                .header-navigation a {
                    display: inline-block;
                }

                .header-navigation button {
                    display: none;
                }
            }

            #content{
                margin-left: 10px;
            }
        </style>


    </head>
    <link rel="stylesheet" href="styles/singleCourseView.css" type="text/css">    

    <header class="header-outer">
        <div class="header-inner responsive-wrapper">
            <div class="header-logo">
                <img src="images/default.png">
            </div>

            <nav class="header-navigation">
                <a href="coursesHome.php">Home</a>
                <a href="myCourses.php">My Courses</a>

                <a href="examResult.php">Quiz Result</a>
                <a href="Student_Profile.php">Student Profile</a>

                <a><img src="images/profile.png" alt="Avatar" class="avatar"></a>
                <a>ID: <?php 
                    echo $_SESSION["id"];

                    ?></a>

        <a href="login.php"><i class="fa fa-sign-out"></i>Log Out</a>


            </nav>
        </div>
    </header>

    <main class="main">
        <div class="main-content responsive-wrapper">

        </div>
    </main>


</html>