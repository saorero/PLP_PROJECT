
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
    <title>Teacher Sign Up</title>
    

    <?php
    include 'databaseconnect.php';



    if(isset($_POST["submit"])){//the code inside will work only when the name submit has been initiated

        $t_id= trim($_POST['teacher_id']);
        $teachername= trim($_POST['teachername']);
        $scode = trim($_POST['schoolcode']);
        $class_id= trim($_POST['class_id']);
        $password= trim($_POST['password_teacher']);
       
        $confirmp = trim($_POST['passwordconfirm']);
        $password_encrypt = password_hash($password, PASSWORD_DEFAULT);

        $errors = array();

    

        if(empty($t_id) OR empty($teachername) OR empty($scode) OR empty($class_id) OR empty($password) OR empty($confirmp)){
            array_push($errors,"All Fields are required");
        }
       
        if($password !== $confirmp){
            array_push($errors,"Passwords are not similar");
        }
       
        //Cheks whether the class_id already exists in the teacherst table
        $sql =" SELECT * FROM teachers WHERE class_id = '$class_id' ";
        $result = $con->query($sql);
        if ($result->num_rows) {

            array_push($errors,"Class has been assigned");

        }

       //Checks whether the entered schoolcode  exists
        $sql =" SELECT * FROM created_schoolsmoe WHERE schoolcode = '$scode' ";
        $result = $con->query($sql);
        if ($result->num_rows == false) {

            array_push($errors,"School is Not Registered check with your Admin");

        }

        //checks whether class has been registered by the admin
        $sql =" SELECT * FROM classes WHERE class_id = '$class_id' ";
        $result = $con->query($sql);
        if ($result->num_rows == false) {

            array_push($errors,"Class is Not Registered check with School Admin");

        }

        //Ensures user enters a class with the correct school code associated with it
        $sql = "SELECT * FROM classes WHERE class_id='$class_id' AND schoolcode = '$scode'";
        $result = $con->query($sql);
        if ($result->num_rows == false) {

            array_push($errors,"Class is Not in this school");

        }


        if(count($errors)>0){
            foreach ($errors as $error){
                echo $error;
            }
        }
        else{
            $stmt=$con->prepare("INSERT INTO teachers (teacher_id, teachername, schoolcode, class_id, password) VALUES (?, ?, ?, ?, ?)");

         

            $stmt->bind_param("sssss", $t_id, $teachername, $scode,$class_id,$password_encrypt );

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Signed Up Successfully";
                header("Location: teacher_login.php");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
               
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
           <button type="button"><a href="teacher_login.php">Login</a></button>
           
        </div>
       
    </div>
    <main>
    <div class="creationmoe">

        
        <div>
            <img src="./images/searching.png" alt="not Found" class="searchMan">
        </div>
        
        <div class="moeform" >
            <div class="formhead"><h3>Teacher Account Creation</h3></div>
            <div class="moeform2" >
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">


                <i class="fa-solid fa-id-card-clip fa-xl"></i>
                    <input type="text" name="teacher_id" id="teacher_id" placeholder="Teacher Id" ><br>


                    <i class="fa-solid fa-person-circle-question fa-xl"></i>
                    <input type="text" name="teachername" id="teachername" placeholder="Teacher Name" ><br>

                    <i class="fa-solid fa-school-lock fa-xl"></i>
                    <input type="text" name="schoolcode" id="schoolcode" placeholder="School Code" ><br>

                    <i class="fa-solid fa-chalkboard-user fa-xl"></i>
                    <input type="text" name="class_id" id="class_id" placeholder="Class Id" ><br>

                    <i class="fa-solid fa-lock  fa-xl"></i>
                    <input type="password" name="password_teacher" id="password_teacher" placeholder="Enter Password" ><br>
                    <i class="fa-solid fa-circle-check fa-xl"></i>
                    <input type="password" name="passwordconfirm" id="passwordconfirm" placeholder="Confirm Password" >
                    <input type="submit" value="Register" name="submit">

                    <p>Have an account?<a href="teacher_login.php">Login</a></p>
                </form>

                
            </div>
        </div>
    </div>
    </main>
</body>
</html>