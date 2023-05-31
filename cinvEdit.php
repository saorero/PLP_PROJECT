
<?php
session_start();



include 'databaseconnect.php';



//UPDATING CLASS INVENTORY
if(isset($_GET['cinventoryid'])){
    $cinventoryid=$_GET["cinventoryid"];
    $sql = "SELECT * FROM class_inventory WHERE cinventoryid='$cinventoryid'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    $initialdate = $row['received_date'];
    
    
}

if(isset($_POST["editcinv"])){
    $cinventoryid= trim($_POST['cinventoryid']);
   
    $citemdesc = trim($_POST['citemdesc']);

    $csubject = trim($_POST['subject']);
  
    $squantity = trim($_POST['quantity']);
   
    $sstatus = trim($_POST['status']);
       
       $requestdate = trim($_POST['initialdate']);
       

    $sql = "UPDATE class_inventory
            SET  citemdesc = '$citemdesc', subject = '$csubject', status = '$sstatus',quantity = '$squantity' , received_date='$requestdate' WHERE cinventoryid = '$cinventoryid' ";

if ($con->query($sql) === TRUE) {
  
 
    header("Location: class_inventory.php");
    echo "Request updated successfully";
   

  
    
  } else {
    echo "Error updating record: " . $con->error;
  }         

}

?>
<link href="inventoryregion.css" rel="stylesheet">
    <title>Allocated Resources Edit</title>

    <div class="editRequest" id="editrequest">
        <form action="" method="POST">

            <span onclick="document.getElementById('editrequest').style.display='none'; " 
            
            id="close"><a href="class_inventory.php">&times;</a> </span> 
             
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Allocation Edit</h3><br>

            <input type="hidden" name= "cinventoryid" value="<?php echo  $row["cinventoryid"];  ?>">
         
            
            <input type="text" id="citemdesc" name="citemdesc" value="<?php echo $row["citemdesc"];?>" ><br><br>

           
            

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" value="<?php echo $row["subject"] ?>" ><br><br>

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity"  value="<?php echo $row["quantity"] ;?>" >
           <br><br>

            

            <label for="initialdate">Date Received</label>
            <input id="initialdate"  name="initialdate" value="<?php echo $initialdate; ?>">

       
            <br><br>
           
           <label for="status">Status</label>
           <select id="status" name="status" >
                <option value="" disabled selected>Status</option>
                <option value="Received"   <?php  if($row['status']=="Received"){echo "selected"; } ?>>Received</option>
                <option value="Not received"   <?php  if($row['status']=="Not received"){echo "selected"; } ?>>Not received</option>
               
            </select><br><br>


            <input type="submit" value="UPDATE" name="editcinv"   onclick="document.getElementsByClassName('editRequest').style.display='none'  " >
            
            
            
        </form>
      
        
    </div>