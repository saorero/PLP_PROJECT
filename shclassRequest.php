<?php

session_start();
//checks if the user is logged in if not redirects to the login page ensures only logged in users can access the dashboard
if(!isset($_SESSION["schooladmin"])){
    header("Location: school_login.php");
}


if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: school_login.php");
    exit;
}
include 'databaseconnect.php';

?>
<link href="moedashboard.css" rel="stylesheet">
<link href="shclassRequest.css" rel="stylesheet">
  
  <title>Requests</title>

  <div class="minTop">
    
        <div class="minTople">

            <img src="./images/officialLogo.png" alt="notfound" class="sclogo">
                <div class="try">
             
                <h3><?php echo  $_SESSION["adminSchool"] ; ?> Class Requests</h3><br>
                <h3><?php echo  "School Admin:" .$_SESSION["adminName"]; ?></h3><br>

                <i class="fa-solid fa-circle-arrow-left fa-2x"></i><a href="schooldashboard.php"> Back</a>
                
                </div>
        
        </div>
        <div class="minTopre">
            <i class="fa-solid fa-landmark-flag fa-2x"> </i>
            <form method="post" class="rlog">
                <input type="submit" name="logout" value="Logout" id="slogout" >
            </form>
          
        </div>
        

    </div>


    
    <div class="list_inventory">
        
        <table >
            <thead>
            <tr class="headings">
                
                <th>Request Id</th>
                <th>Class Id</th>
                <th>Item Description</th>
                <th>Subject</th>
                <th>Grade</th>
                
                <th>Quantity</th>
                <th>Request Date</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            //Displaying the values in the database
            $sql = "SELECT * FROM class_requests WHERE schoolcode = '{$_SESSION['schoolCode']}'";

                $result = $con->query($sql);
                if($result->num_rows>0) {
                   
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[crequest_id] </td>
                            <td>$row[class_id]</td>
                            <td>$row[itemdesc]</td>

                            <td>$row[subject]</td>
                            <td>$row[grade]</td>
                           
                            <td>$row[quantity]</td>
                            <td>$row[request_date]</td>
                            <td>$row[status]</td>
                           

                        </tr>

                        ";
                        
                    }
                }
                $con->close();
            
            ?>

            
        </tbody>
        </table>

    

    </div>