
<?php
session_start();
if(isset($_SESSION["schooladmin"])){
        header("Location: schooldashboard.php");
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
    <title>Login School</title>

    <?php
    include 'databaseconnect.php';
    
//PHP Code
$errors=array();
    if(isset($_POST["login"])){
        $tscno= trim($_POST['tscno']);
        $password= trim($_POST['password_school']);
      
        //checks whether the user exists
        $sql = "SELECT * FROM school_admin WHERE tscno = '$tscno' ";
        $result = $con->query($sql);

        $schooladmin = $result -> fetch_array(MYSQLI_ASSOC);


        if($schooladmin){//the user exists
            $_SESSION["schoolCode"] =   $schooladmin["schoolcode"];

            //ADD A WAY THAT THE USER SCODE CAN BE ASSOCIATED WITH A SCHOOLNAME

       $sqlsn = "SELECT created_schoolsmoe.schoolname FROM created_schoolsmoe INNER JOIN school_admin ON created_schoolsmoe.schoolcode = school_admin.schoolcode WHERE created_schoolsmoe.schoolcode =  '{$_SESSION['schoolCode']}'";
       $resultsn = $con->query($sqlsn); 
       $adminschool = $resultsn -> fetch_array(MYSQLI_ASSOC);
    


            $_SESSION["adminSchool"] =   $adminschool ["schoolname"];
           

            //verify the encrypted password in database
            if(password_verify($password, $schooladmin["password"])){
                
                //ensures only users who are logged in can access the dashboard by creating sessions
                $_SESSION["schooladmin"] = $tscno;
                
                //OTHER SESSIONS CREATED FOR THE SCHOOL ADMIN
                $_SESSION["adminName"] =   $schooladmin["fullname"];
                $_SESSION["schoolCode"] =   $schooladmin["schoolcode"];
                $_SESSION["scountyCode"] =   $schooladmin ["countycode"];


                //if logged in redirect to the moedashboard page
                header("Location: schooldashboard.php"); 
                die();
            }else{
                echo "Enter Password";
            }
        }else{
            echo "TSC No does not exist";
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
        
        <div class="moeform" id="mmt" >
       
            <div class="formhead"><h3>School Administrator Account Login</h3></div>
            <div>
                <form action="school_login.php" method="post">
                    <i class="fa-solid fa-id-card-clip fa-xl"></i>
                    <input type="text" name="tscno" id="tscno" placeholder="TSC No"  ><br>
                    
                    <i class="fa-solid fa-lock  fa-xl"></i>
                    <input type="password" name="password_school" id="password_school" placeholder="Enter Password"><br>
                   
                    <input type="submit" value="Login" name="login">
                    
                    <p>Dont have an account?<a href="school_signup.php">Register</a></p>
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