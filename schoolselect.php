<?php
//REMOVE THIS SECTION WHEN DONE
header("Cache-Control: no-cache, must-revalidate");
//IT ENDS HERE

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
   
    <link href="inventoryregion.css" rel="stylesheet"  > 
   
    
    <title>Selected School</title>

    
    <?php 
        include 'databaseconnect.php';
    //ensures only logged in users can access the dashboard :: checks if the user is logged in if not redirects to the login page

    if(!isset($_SESSION["moeuser"])){
        header("Location: ministry_login.php");
    }

    $selected_school = $_GET['schoolcode'];
// TRYING TO GET THE ASSOCIATED SCHOOL BASED ON THE SELECTED SCHOOL CODE

$sql = "SELECT schoolname FROM created_schoolsmoe WHERE schoolcode = '$selected_school'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  
} 
    
    ?>

</head>
<body>

    <div class="minTop">
        <div class="minTople">
            <img src="./images/officialLogo.png" alt="notfound">
            <i class="fa-solid fa-circle-arrow-left fa-2x"></i><a href="moedashboard.php"> Back</a>
           
            
        </div>
        <div class="minTopre">

            <i class="fa-solid fa-landmark-flag fa-2x"></i>
           
            <h2><?php echo $_SESSION["countyName"] ." :" ;
             echo $row['schoolname']; ?></h2>
            
            
           
        </div>

    </div>
     <!--COMING UP WITH THE ACTIONS THAT CAN BE PERFORMED  -->
     
    <button class= "irequest" id="sinventory" onclick="display1()"><a>School Inventory</a></button>
    <button class ="irequest"  id="srequests"  onclick="display2()"><a>School Request</a></button>


    <h1>School Resource Inventory</h1> 
   
    <div class="list_inventory" id="schinventory" >
        
    
        <table id="moetable">
            <thead>
            <tr class="headings">
                
                <th>Inventory Id</th>
                
                <th>Item Description</th>
                <th>Subject</th>
                <th>Grade</th>
                <th>Received From</th>
                <th>Quantity</th>
                <th>Received Date</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            //Displaying the values in the database
            //Assigns what value has been selected from the table to selected_school
           

            

            $sql = "SELECT * FROM school_inventory WHERE schoolcode = '$selected_school'  ";
               
                $result = $con->query($sql);
                if($result->num_rows>0) {
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[sinventory_id] </td>
                            
                            <td>$row[itemdesc]</td>

                            <td>$row[subject]</td>
                            <td>$row[grade]</td>
                            <td>$row[receivedfrom]</td>
                            <td>$row[quantity]</td>
                            <td>$row[receiveddate]</td>
                            <td>$row[status]</td>
                           

                        </tr>

                        ";
                    }
                }
               
                
            
            ?>
     
      
        </tbody>
        </table>

    

    </div><br><br><hr>
    <h1>School Requests</h1> 
   <div id="schRequest">
    
  <!--DISPLAYIG THE REQUEST OF THE ASSOCIATED SCHOOL-->
  
  <table id="moeRequesttable">
            <thead>
            <tr class="headings">
                
                <th>Request Id</th>
                
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
            //Assigns what value has been selected from the table to selected_school
           
            $selected_school = $_GET['schoolcode'];
           
            

            $sql = "SELECT * FROM schoolrequests WHERE schoolcode = '$selected_school' AND status = 'Not Received' ";
               
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
                           

                        </tr>

                        ";
                    }
                }
                $con->close();
                
            
            ?>
     
      
        </tbody>
        </table>


   
   </div>
   
   <script>
    //Display the table when the inventory button is clicked
    function display1(){
        let schInventory = document.getElementById("schinventory")
        let schrequest = document.getElementById("schRequest")

       schInventory.style.display = "block"; 
       schrequest.style.display = "none" ;
       

    }
    function display2(){
        let schInventory = document.getElementById("schinventory")
        let schrequest = document.getElementById("schRequest")
       schInventory.style.display = "none"; 
       schrequest.style.display = "block" ;

    }

   
   </script>
</body>
</html>
