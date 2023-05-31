


<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
      integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!--STYLING LINKS-->
    <link href="popform.css" rel="stylesheet" />
    <link href="moeschools.css" rel="stylesheet" />
    <title>School Classes</title>

    <?php 
        include 'databaseconnect.php';
    //ensures only logged in users can access the dashboard :: checks if the user is logged in if not redirects to the login page
   
    
    if(!isset($_SESSION["schooladmin"])){
        header("Location: school_login.php");
    }

    //PHP CODE FOR INSERTING CREATED CLASSES IN THE SCHOOL classes table

    if(isset($_POST["submit"])){//the code inside will work only when  submit has been initiated

        $class_id= trim($_POST['class_id']);
        $sgrades= trim($_POST['sgrades']);
       // $teacher_id= trim($_POST['teacher_id']);
        $tstudents= trim($_POST['totalstudents']);
       
        $schoolcode= trim($_POST['schoolcode']);


        $errors = array();

        //DEFINING ERRORS

        if(empty($class_id)  ){
            array_push($errors,"Class Id Should be filled ");
        }

        if(empty($sgrades)  ){
            array_push($errors,"Choose Grade");
        }
        /*if(empty($teacher_id)  ){
            array_push($errors,"Teacher Id should be filled");
        }*/
        
        //Searching through the database to see if the class id already exists
        $sql = "SELECT * FROM classes WHERE class_id = '$class_id' ";
        $result = $con->query($sql); 
        if ($result->num_rows > 0) { array_push($errors,"Class Already exists"); } 

        //Checks whether the schoolcode entered is the same as schoolcode of the current school admin //If not same the user cannot register a class
    if($schoolcode !=  $_SESSION["schoolCode"]){ 
      array_push($errors,"Enter Valid School Code"); } 
    
      if(count($errors)>0){ foreach ($errors as $error){ echo $error; } }

      else{ 
        $sql = " INSERT INTO classes (class_id, grade,totalstudents, schoolcode) VALUES ('$class_id', '$sgrades','$tstudents','$schoolcode' )";
        
        if($con->query($sql) === TRUE) { echo "Class Added Successfully";
        header("Location: schoolclasses.php"); } 
        else { echo "Error: " . $sqli . " <br />" . $con->error; } }
    
    } 
    
    
      
    
    
    ?>
  </head>
  <body>
    <div class="minTop">
      <div class="minTople">
        <img src="./images/officialLogo.png" alt="notfound" />
        
        <div class="try">
                
                <h3><i class="fa-solid fa-user-lock fa-1x"></i><?php echo  $_SESSION["schooladmin"];?></h3><br>
                <h3><?php echo  "School Admin:" .$_SESSION["adminName"]; ?></h3>
                
                </div>
        
      </div>
      <div class="minTopre">
        <i class="fa-solid fa-landmark-flag fa-2x"></i>
        <h3>
          <?php echo  $_SESSION["adminSchool"]; ?>
           Classes Section
        </h3>
      </div>
    </div>

    <main>
      <div class="choice">
        <ul>
        <li><a href="#"><i class="fa-solid fa-calendar-days fa-2x"></i><?php echo  date("Y/m/d") ; ?></a></li>
                <li><i class="fa-solid fa-house-user fa-2x"></i><a href="schooldashboard.php">Dashboard</a></li>
                
                <li><i class="fa-solid fa-school fa-2x"></i><a href="schoolclasses.php">Classes</a></li>
                <li><i class="fa-regular fa-clipboard fa-2x"></i><a href="school_inventory.php">School Inventory</a></li>
                <li><i class="fa-solid fa-pen-to-square fa-2x"></i><a href="#">Class Requests</a></li>
                <li><i class="fa-solid fa-book fa-2x"></i><a href="schoolrequest.php">Make Request</a></li>
                
        </ul>
      </div>

      <div class="middleheading">
        <h1>
          <?php echo   $_SESSION["adminSchool"]; ?>
          Classes
        </h1>
        <button
          id="newclass"
          onclick="document.getElementById('registerclass').style.display='block'"
        >
           Add Class
        </button>
      </div>
    </main>

    <div class="listedschools" >
      <!--COMING UP WITH THE SEARCH BAR-->

      <div class="trySearch">
        <input type="text" placeholder="Class Search" id="searchclass"  onkeyup="mySearch()"/> 
        
        </div>
      
        
      
      <br />

      <table id="classTable">
        <thead>
          <th>Class Code</th>
          <th>Grade</th>
          <th>Teachers Name/ID</th>
          <th>Total Students</th>

          <!--  <th>Total Students</th>  <th>Admins name</th>will be provided by the school-->
        </thead>
        <tbody>
          
          <?php
                //Displaying the classes created by the schooladmin which only appears when the teacher has signed up //others  like teachers name will come later
              $sql = "SELECT classes.class_id, classes.grade,teachers.teachername,classes.totalstudents FROM classes INNER JOIN teachers ON classes.class_id = teachers.class_id WHERE classes.schoolcode = '{$_SESSION["schoolCode"]}' ";

              $result = $con->query($sql);
                /*$sql = "SELECT class_id, grade,totalstudents FROM classes WHERE schoolcode = '{$_SESSION["schoolCode"]}' ";
                    $result = $con->query($sql); */
                     if ($result->num_rows > 0) { //output data of each row
                       while($row = $result->fetch_assoc()) 
                       { echo"
          <tr>
            <td><a href='classSelect.php?class_id={$row['class_id']}'>{$row['class_id']}</a></td>
            <td >$row[grade]</td>
            <td>$row[teachername]</td>
            <td>$row[totalstudents]</td>
          </tr>"; 
          } }
          
          $con->close(); ?>
        </tbody>
      </table>
    </div>

    <!--REGISTER CLASS POP FORM-->
          
    <div id="registerclass">
      <form action="#" method="POST">
        <span
          onclick="document.getElementById('registerclass').style.display='none'"
          id="close"
        >
          &times;</span
        >

        <img
          src="./images/Track_Me_Logo-01-removebg-preview.png"
          alt="not found"
        />
        <h3>Register New Class</h3>
        <br />

        <input
          type="text"
          id="class_id"
          name="class_id"
          placeholder="Class Id"
          required
        /><br /><br />

        <select id="sgrades" name="sgrades" >
                <option value="" disabled selected>Grade</option>
                <option value="Grade1">Grade 1</option>
                <option value="Grade2">Grade 2</option>
                <option value="Grade3">Grade 3</option>
                <option value="Grade4">Grade 4</option>
                <option value="Grade5">Grade 5</option>
                <option value="Grade6">Grade 6</option>
                <option value="Grade7">Grade 7</option>
                <option value="Grade8">Grade 8</option>
                <option value="Grade9">Grade 9</option>
        </select><br><br>
        
        <input type = "text" id="sschoolcode" name="schoolcode" placeholder="School Code"><br /><br />
        <!--PUT IT IN SUCH A WAY THAT THE totalstudent values can come from the teachers-->
        <input type = "number" id="totalstudents" name="totalstudents" placeholder="Total Students">
        <br /><br />
       

       
        <input
          type="submit"
          value="Register"
          name="submit"
          onclick="document.getElementById('registerclass').style.display='none'"
        />
      </form>
    </div>

    <script>
      //SEARCHING FUNCTION
    function mySearch() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchclass");
      filter = input.value.toUpperCase();
      table = document.getElementById("classTable");
      tr = table.getElementsByTagName("tr");
    
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
  </body>
</html>
