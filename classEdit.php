
<?php
session_start();




include 'databaseconnect.php';
//UPDATING REQUEST
if(isset($_GET['crequest_id'])){
    $requestid=$_GET["crequest_id"];
    $sql = "SELECT * FROM class_requests WHERE crequest_id='$requestid'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    $initialdate = $row['request_date'];
    
    
}

if(isset($_POST["ceditRequest"])){
    
    $crequest_id= trim($_POST['crequest_id']);
    $clcode= trim($_POST['class_id']);
    
    $citemdesc = trim($_POST['itemdesc']);

    $csubject = trim($_POST['subject']);
    $cgrade = trim($_POST['grade']);

   
    $cquantity = trim($_POST['quantity']);
    //$requestdate = trim($_POST['requestdate']);
    $cstatus = trim($_POST['status']);
        
      

    
       
       $requestdate = trim($_POST['initialdate']);
    

    $sql = "UPDATE class_requests
            SET status = '$cstatus', request_date ='$requestdate' , quantity= '$cquantity', subject = '$csubject',itemdesc = '$citemdesc'WHERE crequest_id = '$crequest_id' ";

if ($con->query($sql) === TRUE) {
  
 echo "<script>alert('Request Updated Successfully')</script>";
    header("Location: classrequest.php");
    echo "Request updated successfully";
   

  
    
  } else {
    echo "Error updating record: " . $con->error;
  }         

}

//END UPDATE REQUEST


?>


<link href="inventoryregion.css" rel="stylesheet">
    <title>Edit Class Request</title>

    
  
  <div class="editRequest" id="editrequest">
        <form action="" method="POST">

            <span onclick="document.getElementById('editrequest').style.display='none'; " 
            
            id="close"><a href="classrequest.php">&times;</a> </span> 
             
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Edit Resource Request</h3><br>

            <input type="hidden" name= "crequest_id" value="<?php echo  $row["crequest_id"];  ?>">
         
           
          
            <input name= "itemdesc" value="<?php echo  $row["itemdesc"];  ?>"><br><br>

           
            

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject"  value="<?php echo $row["subject"] ?>" ><br><br>

            <label for="quantity">Quantity</label>
            <input name= "quantity" value="<?php echo  $row["quantity"];  ?>"><br><br>

            <label for="initialdate">Requested Date</label>
            <input id="initialdate" name="initialdate" value="<?php echo $initialdate; ?>">

          <!-- <label for="requestdate">DateRequested<input type="date" id="requestdate" name="requestdate" value="<?//php echo $row["requestdate"]; ?>" readonly></label>--> 
            <br><br>
           
           <label for="status">Status</label>
           <select id="status" name="status" >
                <option value="" disabled selected>Status</option>
                <option value="Received"   <?php  if($row['status']=="Received"){echo "selected"; } ?>>Received</option>
                <option value="Not received"   <?php  if($row['status']=="Not received"){echo "selected"; } ?>>Not received</option>
               
            </select><br><br>


            <input type="submit" value="UPDATE" name="ceditRequest"   onclick="document.getElementsByClassName('editRequest').style.display='none'  " >
            
            
            

  
         
            
            
            
        </form>
      
        
    </div>

    