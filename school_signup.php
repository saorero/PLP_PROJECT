
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
    <title>Sign Up School</title>
    

    <?php
    include 'databaseconnect.php';



    if(isset($_POST["submit"])){//the code inside will work only when the name submit has been initiated

        $tscno= trim($_POST['tscno']);
        $fullname= trim($_POST['fullname']);
        $scode = trim($_POST['schoolcode']);
        $ccode= trim($_POST['countycode']);
        $password= trim($_POST['password_school']);
       
        $confirmp = trim($_POST['passwordconfirm']);
        $password_encrypt = password_hash($password, PASSWORD_DEFAULT);

        $errors = array();

    

        if(empty($tscno) ){
            array_push($errors,"Fill in the TSC No field");
        }
        if(empty($scode) ){
            array_push($errors,"School Code should be filled");
        }

        if($password !== $confirmp){
            array_push($errors,"Password is not similar in both fields");
        }
        //Searching through the database to see if the tscno already exists
        $sql_reentry = "SELECT * FROM school_admin WHERE tscno= '$tscno' ";
        $result = $con->query($sql_reentry);
        if ($result->num_rows > 0) {

            array_push($errors,"User with this TSC NO Already Exists");

        }

            //CREATE AN ERROR THAT CHECKS WHETHER SCHOOL CODE IS IN THE EXACT COUNTY
       
        

        //AN ERROR THAT CHECKS WHTHER THE SCHOOL IS IN created_schoolsmoe 
        $sql =" SELECT * FROM created_schoolsmoe WHERE schoolcode = '$scode' ";
        $result = $con->query($sql);
        if ($result->num_rows == false) {

            array_push($errors,"School is Not Registered check with the ministry");

        }

        //CHECKS WHETHER THE schooladmin has already registered
        $sql =" SELECT * FROM school_admin WHERE schoolcode = '$scode' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {

            array_push($errors,"School Admin already signed up");

        }

        //CHECKS WHETHER THE SCHOOL CODE IS MATCHING WITH THE COUNTY IT IS IN
        $sql = " SELECT  * FROM created_schoolsmoe WHERE schoolcode = '$scode' AND countycode = '$ccode' ";
        $result = $con->query($sql);
        if($result->num_rows == false){
            array_push($errors,"The school is not registered in this county");
        }

        if(count($errors)>0){
            foreach ($errors as $error){
                echo $error;
            }
        }
        else{

            $sql = " INSERT INTO school_admin( tscno, fullname, schoolcode, countycode, password) VALUES ('$tscno', '$fullname', '$scode','$ccode', '$password_encrypt')";

            if ($con->query($sql) === TRUE) {


               echo " 'Registered Successfully ";
              

               header("Location: school_login.php");
             
            } else {
                echo "Error: " . $sqli . "<br>" . $con->error;
            }
               
        }

            

    }     

    $con->close();

?>


    
</head>
<body>
    <div class="min_top">
        <div>
            <img src="./images/officialLogo.png" alt="not found">
        </div>
        <div class="min_top2">
            <i class="fa-solid fa-arrow-right-to-bracket fa-2x"></i>
           <button type="button"><a href="school_login.php">Login</a></button>
           
        </div>
       
    </div>
    <main>
    <div class="creationmoe">

        
        <div>
            <img src="./images/searching.png" alt="not Found" class="searchMan">
        </div>
        
        <div class="moeform" >
            <div class="formhead"><h3>Ministry of Education School Administrator Account Creation</h3></div>
            <div class="moeform2" >
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">


                <i class="fa-solid fa-id-card-clip"></i>
                    <input type="text" name="tscno" id="tscno" placeholder="TSC Number" ><br>


                    <i class="fa-solid fa-person-circle-question fa-xl"></i>
                    <input type="text" name="fullname" id="fullname" placeholder="Administrator Name" ><br>

                    <i class="fa-solid fa-school-lock fa-xl"></i>
                    <input type="text" name="schoolcode" id="schoolcode" placeholder="School Code" ><br>

                    <i class="fa-solid fa-location-pin-lock fa-xl"></i>
                    <input type="number" name="countycode" id="countycode" placeholder="County Code" ><br>

                    <i class="fa-solid fa-lock  fa-xl"></i>
                    <input type="password" name="password_school" id="password_school" placeholder="Enter Password" ><br>
                    <i class="fa-solid fa-circle-check fa-xl"></i>
                    <input type="password" name="passwordconfirm" id="passwordconfirm" placeholder="Confirm Password" >
                    <input type="submit" value="Register" name="submit">

                    <p>Have an account?<a href="school_login.php">Login</a></p>
                </form>

                
            </div>
        </div>
    </div>
    </main>
</body>
</html>