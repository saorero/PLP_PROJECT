
<?php
session_start();
if(isset($_SESSION["teacher"])){
        header("Location: teacherdashboard.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <link rel="stylesheet"   href="./forms.css">
    <title>Teacher Login</title>

    <?php
    include 'databaseconnect.php';
    
//PHP Code
$errors=array();
    if(isset($_POST["login"])){
        $t_id= trim($_POST['teacher_id']);
        $password= trim($_POST['password_teacher']);
      
        //checks whether the user exists
        $sql = "SELECT * FROM teachers WHERE teacher_id = '$t_id' ";
        $result = $con->query($sql);

        $schoolteacher = $result -> fetch_array(MYSQLI_ASSOC);


        if($schoolteacher){//the user exists true
            
            
            //verify the encrypted password in database
            if(password_verify($password, $schoolteacher["password"])){//checks whether the passwords are similar
                
                //ensures only users who are logged in can access the dashboard by creating sessions
                $_SESSION["teacher"] = $t_id;
                
                //OTHER SESSIONS CREATED FOR THE TEACHER
                $_SESSION["teachername"] =   $schoolteacher["teachername"];
                $_SESSION["schoolCode"] =   $schoolteacher["schoolcode"];
                
         
                //Creating Session to store the grade of the teacher
                $sql = "SELECT classes.class_id, classes.grade ,teachers.teacher_id, classes.totalstudents FROM classes INNER JOIN teachers ON classes.class_id = teachers.class_id WHERE teachers.teacher_id =   '{$_SESSION["teacher"]}'";
                $result = $con->query($sql);

                if($result->num_rows>0) {
                    $row=$result->fetch_assoc();
                    $_SESSION["gradeName"] = $row['grade'];
                    $_SESSION["classId"] = $row["class_id"];
                    $_SESSION["totalStudents"] = $row["totalstudents"];
                
                }
                //session for the school name
                $sql = "SELECT schoolname FROM created_schoolsmoe WHERE schoolcode = '{$_SESSION["schoolCode"]}'";
                $result = $con->query($sql);

                if($result->num_rows>0) {
                    $row=$result->fetch_assoc();
                    $_SESSION["schoolName"] = $row['schoolname'];
                
                }


                //if logged in redirect to the teacherdashboard page
                header("Location: teacherdashboard.php"); 
                die();
            }else{
                echo "Enter Password";
            }
        }else{//if the teacher_id does not exist 
            echo "User does not exist";
        }


    }

    ?>




</head>
<body>
    <div class="min_top">
        <div>
            <img src="./images/officialLogo.png" alt="not found">
        </div>
        <div class="min_top2">
            
           <button type="button"> <a href="homepage.php"><i class="fa-solid fa-house fa-1x"></i></a></button>
           
        </div>
       
    </div>
    <main>
    <div class="creationmoe">

        
        <div>
            <img src="./images/searching.png" alt="not Found" class="searchMan">
        </div>
        
        <div class="moeform" >
       
            <div class="formhead"><h3>Teacher Account Login</h3></div>
            <div class="tform">
                <form action="teacher_login.php" method="post">
                    
                    <input type="text" name="teacher_id" id="teacher_id" placeholder="TeacherId/TSC No"  ><br>
                    
                    
                    <input type="password" name="password_teacher" id="password_teacher" placeholder="Enter Password"><br>
                   
                    <input type="submit" value="Login" name="login">
                    
                    <p>Dont have an account?<a href="teacher_signup.php">Register</a></p>
                </form>
            </div>
        </div>

        <div>
            <img src="./images/searching.png" alt="not Found" class="searchMan2">
        </div>
    
    </div>
    </main>
</body>
</html>