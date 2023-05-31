
<?php
session_start();
if(isset($_SESSION["moeuser"])){
        header("Location: moedashboard.php");
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
    <title>Login Ministry</title>

    <?php
    include 'databaseconnect.php';
    
//PHP Code
$errors=array();
    if(isset($_POST["login"])){
        $civilid= trim($_POST['civilservant_id']);
        $password= trim($_POST['password_moe']);
      

        

        //checks whether the user exists
        $sql = "SELECT * FROM moe_users WHERE civilservant_id = '$civilid' ";
        $result = $con->query($sql);

        $moeuser = $result -> fetch_array(MYSQLI_ASSOC);




        if($moeuser){//the user exists
            
            //verify the encrypted password in database
            if(password_verify($password, $moeuser["password"])){
                
                //ensures only users who are logged in can access the dashboard by creating sessions
                
                $_SESSION["moeuser"] = $civilid;
                
                        //Other sessions created
                $_SESSION["countyCode"] =  $moeuser["countycode"];
                $_SESSION["userName"] =  $moeuser["username"];
                $_SESSION["countyName"] =  $moeuser["countyname"];
                //if logged in redirect to the moedashboard page
                header("Location: moedashboard.php"); 
                die();
            }else{
                echo "Enter Password";
            }
        }else{
            echo "Civil Servant Id does not exist";
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
       
            <div class="formhead"><h3>Ministry of Education Account Login</h3></div>
            <div>
                <form action="ministry_login.php" method="post">
                    <i class="fa-solid fa-id-card-clip fa-xl"></i>
                    <input type="text" name="civilservant_id" id="civilservant_id" placeholder="Civil Servant Id"  ><br>
                    
                    <i class="fa-solid fa-lock  fa-xl"></i>
                    <input type="password" name="password_moe" id="password_moe" placeholder="Enter Password"><br>
                   
                    <input type="submit" value="Login" name="login">
                    
                    <p>Dont have an account?<a href="ministry_signup.php">Register</a></p>
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