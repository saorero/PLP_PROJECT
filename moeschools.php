<?php
//REMOVE THIS SECTION WHEN DONE
header("Cache-Control: no-cache, must-revalidate");
//IT ENDS HERE
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
    <title>Schools</title>

    <?php 
        include 'databaseconnect.php';
    //ensures only logged in users can access the dashboard :: checks if the user is logged in if not redirects to the login page
   
    
    if(!isset($_SESSION["moeuser"])){
        header("Location: ministry_login.php");
    }

    //PHP CODE FOR INSERTING CREATED SCHOOLS IN THE MOE CREATED SCHOOL

    if(isset($_POST["submit"])){//the code inside will work only when  submit has been initiated

        $schoolname= trim($_POST['schoolname']);
        $schoolcode= trim($_POST['schoolcode']);
        $ccode= trim($_POST['countycode']);
        $errors = array();

        //DEFINING ERRORS

        if(empty($schoolname)  ){
            array_push($errors,"School Name Should be filled ");
        }

        if(empty($ccode)  ){
            array_push($errors,"County Code is required");
        }
        if(empty($schoolcode)  ){
            array_push($errors,"School Code Should be field ");
        }
        
        //Searching through the database to see if the schoolcode already exists
        $sql = "SELECT * FROM created_schoolsmoe WHERE schoolcode = '$schoolcode' ";
        $result = $con->query($sql); 
        if ($result->num_rows > 0) { array_push($errors,"School Code Already exists"); } 
        //Checks whether the countycode entered is the same as countycode in the moe_users //If not same the user cannot register a school
    if($ccode != $_SESSION["countyCode"]){ 
      array_push($errors,"School Not in Locality"); } 
    
      if(count($errors)>0){ foreach ($errors as $error){ echo $error; } }

      else{ 
        $sql = " INSERT INTO created_schoolsmoe(schoolname, schoolcode, countycode) VALUES ('$schoolname', '$schoolcode', '$ccode')";
        
        if($con->query($sql) === TRUE) { echo "School Added Successfully";
        header("Location: moeschools.php"); } 
        else { echo "Error: " . $sqli . " <br />" . $con->error; } }
    
    } 
    
    
      
    
    
    ?>
  </head>
  <body>
    <div class="minTop">
      <div class="minTople">
        <img src="./images/officialLogo.png" alt="notfound" />
        <i class="fa-solid fa-user-lock fa-2x"></i>
        <h5>Employer Id:<?php echo  $_SESSION["moeuser"] ; ?></h5>
      </div>
      <div class="minTopre">
        <i class="fa-solid fa-landmark-flag fa-2x"></i>
        <h5>
          <?php echo   $_SESSION["countyName"] ; ?>
          Schools Section
        </h5>
      </div>
    </div>

    <main>
      <div class="choice">
        <ul>
          <li>
            <a href="#"
              ><i class="fa-solid fa-calendar-days fa-2x"></i
              ><?php echo  date("Y/m/d") ; ?></a
            >
          </li>
          <li>
            <i class="fa-solid fa-house-user fa-2x"></i
            ><a href="moedashboard.php">Dashboard</a>
          </li>
          <li class="selected">
            <a href="#"><i class="fa-solid fa-school fa-2x"></i>Schools</a>
          </li>
          <li>
            <a href="inventory_region.php"
              ><i class="fa-regular fa-clipboard fa-2x"></i>Regions Inventory</a
            >
          </li>
          <li>
            <a href="moedashboard.php"
              ><i class="fa-solid fa-pen-to-square fa-2x"></i>Requests</a
            >
          </li>
        </ul>
      </div>

      <div class="middleheading">
        <h1>
          <?php echo   $_SESSION["countyName"] ; ?>
          County Registered Schools
        </h1>
        <button
          id="newsch"
          onclick="document.getElementById('registersch').style.display='block'"
        >
          Register New School
        </button>
      </div>
    </main>

    <div class="listedschools" >
     
      
      <table id="schoolsTable">
        <thead>
          <th>School Code</th>
          <th>School Name</th>
          <th>Administrator</th>
          <th>Total Students</th>

          <!--  <th>Total Students</th>  <th>Admins name</th>will be provided by the school-->
        </thead>
        <tbody>
          
          <?php

          

                //Displaying the schools created in createdschools_moe by a given user
               $sql = "SELECT created_schoolsmoe.schoolname, created_schoolsmoe.schoolcode, school_admin.fullname 
        FROM created_schoolsmoe
        INNER JOIN school_admin ON created_schoolsmoe.schoolcode=school_admin.schoolcode
        WHERE created_schoolsmoe.countycode = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['countyCode']);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      
      //Code that calculates the total number of students in every school based on the school code
      $sql = "SELECT SUM(totalstudents) AS totalst FROM classes WHERE schoolcode = '{$row['schoolcode']}'";
      $result_students= mysqli_query($con, $sql);
      $row_students = mysqli_fetch_assoc($result_students);
      $total_students = $row_students['totalst'];

      
        echo "
          <tr>
          <td><a href='schoolselect.php?schoolcode={$row['schoolcode']}'>{$row['schoolcode']}</a></td>
          <td><a href='#'>{$row['schoolname']}</a></td>
          <td><a href='#'>{$row['fullname']}</a></td>

          <td>{$total_students}</td>

          </tr>"; 
    }
}

          
          $con->close(); ?>
        </tbody>
      </table>
    </div>
    <!--REGISTER SCHOOL POP FORM-->
          
    <div id="registersch">
      <form action="#" method="POST">
        <span
          onclick="document.getElementById('registersch').style.display='none'"
          id="close"
        >
          &times;</span
        >

        <img
          src="./images/Track_Me_Logo-01-removebg-preview.png"
          alt="not found"
        />
        <h3>Register New School</h3>
        <br />

        <input
          type="text"
          id="schoolname"
          name="schoolname"
          placeholder="Enter School Name"
          required
        /><br /><br />

        <input
          type="text"
          id="schoolcode"
          name="schoolcode"
          placeholder="Enter School Code"
        /><br /><br />

        <input
          type="number"
          id="countycode"
          name="countycode"
          placeholder="County code of the school"
        /><br /><br />

        <input
          type="submit"
          value="Register"
          name="submit"
          onclick="document.getElementById('registersch').style.display='none'"
        />
      </form>
    </div>

    <script>
      //SEARCHING FUNCTION
    function mySearch() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("search");
      filter = input.value.toUpperCase();
      table = document.getElementById("schoolsTable");
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
