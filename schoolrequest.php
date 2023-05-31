<?php
session_start();
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
  <!--STYLINHG LINKS-->
   
    <link href="inventoryregion.css" rel="stylesheet"> 
   
    
    <title>School Inventory</title>

    
    <?php 
        include 'databaseconnect.php';
    //ensures only logged in users can access the dashboard :: checks if the user is logged in if not redirects to the login page

    if(!isset($_SESSION["schooladmin"])){
        header("Location: school_login.php");
    }

    //Inserting values into the ministry inventory
    if(isset($_POST["submit"])){//the code inside will work only when  submit has been initiated

        $request_id= trim($_POST['request_id']);
        $rscode= trim($_POST['schoolcode']);
        $rccode= trim($_POST['countycode']);
        $ritemdesc = trim($_POST['itemdesc']);

        $rsubject = trim($_POST['subject']);
        $rgrade = trim($_POST['grade']);

       
        $rquantity = trim($_POST['quantity']);
        //$requestdate = trim($_POST['requestdate']);
        $rstatus = trim($_POST['status']);

        $errors = array();

        //DEFINING ERRORS
        //NOT YET DONE AN ERROR THAT CHECKS WHTHER HE SCHOOL CODE IS THE SAME AS THE COUNTY CODE

        if(empty($request_id)  OR empty($ritemdesc) OR empty($rsubject) OR empty($rgrade)  OR empty($rquantity) ){
            array_push($errors,"Required Fields!");
        }

     
        
        //Searching through the database to see if the inventory already exists
        $sql = "SELECT * FROM schoolrequests WHERE request_id = '$request_id' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {

            array_push($errors,"Re-enter a diffrent Request Id");

        }

        


        if(count($errors)>0){
            foreach ($errors as $error){
                echo $error;
            }
        }else{
            


            $sql = "INSERT INTO schoolrequests(request_id,  schoolcode, countycode, itemdesc, subject, grade, quantity, status) VALUES ('$request_id', '$rscode', '$rccode','$ritemdesc', '$rsubject', '$rgrade','$rquantity','$rstatus')";

            if ($con->query($sql) === TRUE) {
              
               echo "Request Sent";
               header("Location: schoolrequest.php");
             
            } else {
                echo "Error: " . $sqli . "<br>" . $con->error;
            }
               
        }

            

    } 
    

    

    
    ?>
    
   
</head>
<body   onload="currentTimestamp()">

    <div class="minTop">
        <div class="minTople">
            <img src="./images/officialLogo.png" alt="notfound">
            <i class="fa-solid fa-circle-arrow-left fa-2x"></i><a href="schooldashboard.php"> Back</a>
           
            
        </div>
        <div class="minTopre">

            <i class="fa-solid fa-landmark-flag fa-2x"></i>
            <h3>Employer Id:<?php echo  $_SESSION["schooladmin"] ; ?></h3><br>
            <h3><?php echo  "::".$_SESSION["adminSchool"] ; ?></h3>
        </div>

    </div>
    <h1><?php echo  $_SESSION["adminSchool"]; ?> Request Ledger</h1> 
    <a href="#" role="button" class="searchBt"  onclick="document.getElementById('newrequest').style.display='block'">New Request</a>

    <input type="text" placeholder="Date Request Search" id="requestsearch"  onkeyup="requestSearch()"/> 
    
    <div class="list_inventory">
        
    
        <table id="requesttable">
            <thead>
            <tr class="headings">
                
                <th>Request Id</th>
                
                <th>Item Description</th>
                <th>Subject</th>
                <th>Grade</th>
                
                <th>Quantity</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //Displaying the values in the database
            $sql = "SELECT * FROM schoolrequests WHERE schoolcode = '{$_SESSION['schoolCode']}'";

                $result = $con->query($sql);
                if($result->num_rows>0) {
                   
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[request_id] </td>
                            
                            <td>$row[itemdesc]</td>

                            <td>$row[subject]</td>
                            <td>$row[grade]</td>
                           
                            <td>$row[quantity]</td>
                            <td>$row[requestdate]</td>
                            <td>$row[status]</td>
                            <td>
                            <a role='button' href='schoolEdit.php?request_id=$row[request_id]' class='controls'>Update</a>

                            <a role='button' href='delete.php?request_id=$row[request_id]' class='controls'>Delete</a>
                            </td>

                        </tr>

                        ";
                        
                    }
                }
                $con->close();
            
            ?>

            
        </tbody>
        </table>

    

    </div>
    <div id="newrequest">


        <form action="#" method="POST">
            
            <span onclick="document.getElementById('newrequest').style.display='none'" id="close"> &times;</span> 
            
           
           
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Make Request</h3><br>
          
            <input type="text" id="request_id" name="request_id" placeholder="Request Id" required><br><br>

           <!--Hidden Input Fields-->
            <input type="text" id="schoolcode" name="schoolcode"  value="<?php echo $_SESSION['schoolCode']; ?>" hidden >

            <input type="text" id="countycode" name="countycode"   value="<?php echo $_SESSION["scountyCode"]; ?>" hidden >
           <!--End of input hidden fields-->
            <input type="text" id="itemdesc" name="itemdesc" placeholder="Item Description" ><br><br>


            <input type="text" id="subject" name="subject" placeholder="Subject" ><br><br>

            <select id="grade" name="grade" >
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

            <input type="number" id="quantity" name="quantity" placeholder="Item Quantity" required>
           <br><br>
            
           <label for="requestdate">Date Requested<input type="text" id="requestdate" name="requestdate"  readonly></label>
           <br><br>

       <input type="text" id="status" name="status" value="Not Received" readonly><br><br>
              <!--  
            <select id="status" name="status" >
                <option value="Not Received" disabled selected>Status</option>
                <option value="Received">Received</option>
                <option value="Not received">Not received</option>
               
            </select><br><br>

            -->
            <input type="submit" value="Send" name="submit"   onclick="document.getElementById('newrequest').style.display='none'">
            
    
            
            
        </form>
        
    </div>
   
    <!--JAVASCRIPT FOR ITEM SEARCH-->
    <script>
      //SEARCHING FUNCTION
    function requestSearch() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("requestsearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("requesttable");
      tr = table.getElementsByTagName("tr");
    
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[5];
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


     //A CODE THAT DISPLAYS THE CURRENT TIMESTAMP ON THE RECEIVED DATE INPUT
     function currentTimestamp(){
    
    var currentDate = new Date();
        let timestamp = document.getElementById("requestdate")
        let format ={
            timeZone:"Africa/Nairobi",
            year :"numeric",
            month :"2-digit",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit"


        }
        timestamp.value = currentDate.toLocaleString("en-US", format);
       
    }
    </script>
</body>
</html>