<?php
session_start();
include 'databaseconnect.php';
if(!isset($_SESSION["schooladmin"])){
    header("Location: school_login.php");
}



$selected_class = $_GET['class_id'];

$sql = "SELECT * FROM classes WHERE class_id = '$selected_class'";

$result = $con->query($sql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $currentClass =  $row['grade'];
  $specificClass = $row['class_id'];
  $schcode =  $row['schoolcode'];
  
} 





?>
    <link href="inventoryregion.css" rel="stylesheet"  > 
   <title>Class Selected </title>
   <body>
   <div class="minTop">
        <div class="minTople">
            <img src="./images/officialLogo.png" alt="notfound">
            <i class="fa-solid fa-circle-arrow-left fa-2x"></i><a href="schoolclasses.php"> Back</a>
           
            
        </div>
        <div class="minTopre">

            <i class="fa-solid fa-landmark-flag fa-2x"></i>
            <div class="try" >
                <h2><?php
                echo $_SESSION["adminSchool"]  ; 
                ?></h2>
                <h2><?php
                echo  $currentClass. "-" . $specificClass ; 
                ?></h2>
            </div>
            
           
        </div>

    </div>

    <!--Displays The specific class details-->

    <h1>Class Resource Allocation</h1> 
    
    
    <div class="list_inventory">
        
    
        <table id="moetable">
            <thead>
            <tr class="headings">
                
                <th>Inventory Id</th>
                
                <th>Item Description</th>
                <th>Subject</th>
                <th>Quantity</th>
                <th>Received Date</th>
                
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //Displaying the values in the database
            $sql = "SELECT * FROM class_inventory WHERE class_id = '$specificClass' ";
               
                $result = $con->query($sql);
                if($result->num_rows>0) {
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[cinventoryid] </td>
                            
                            <td>$row[citemdesc]</td>

                            <td>$row[subject]</td>
                            
                            <td>$row[quantity]</td>

                            <td>$row[received_date]</td>
                       
                            <td>$row[status]</td>
                            <td>
                           

                            <a role='button' href='deleteCinvs.php?cinventoryid=$row[cinventoryid]' class='controls'>Delete</a>

                            
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


   </body>