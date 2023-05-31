
<?php
session_start();




include 'databaseconnect.php';
//UPDATING REQUEST
if(isset($_GET['request_id'])){
    $requestid=$_GET["request_id"];
    $sql = "SELECT * FROM schoolrequests WHERE request_id='$requestid'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    $initialdate = $row['requestdate'];
    
    
}

if(isset($_POST["editRequest"])){
    $request_id= trim($_POST['request_id']);
        $rscode= trim($_POST['schoolcode']);
      

        $rsubject = trim($_POST['subject']);
       
       $requestdate = trim($_POST['initialdate']);
        $rstatus = trim($_POST['status']);

    $sql = "UPDATE schoolrequests
            SET status = '$rstatus', requestdate ='$requestdate' WHERE request_id = '$requestid' ";

if ($con->query($sql) === TRUE) {
  
 echo "<script>alert('Request Updated Successfully')</script>";
    header("Location: schoolrequest.php");
    echo "Request updated successfully";
   

  
    
  } else {
    echo "Error updating record: " . $con->error;
  }         

}

//END UPDATE REQUEST


?>


<link href="inventoryregion.css" rel="stylesheet">
    <title>Edit Request</title>

    <!--Changing the Request status only From MOE-->
  
  <div class="editRequest" id="editrequest">
        <form action="" method="POST">

            <span onclick="document.getElementById('editrequest').style.display='none'; " 
            
            id="close"><a href="schoolrequest.php">&times;</a> </span> 
             
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Change Status</h3><br>

            <input type="hidden" name= "request_id" value="<?php echo  $row["request_id"];  ?>">
         
           


            
            <input type="text" id="schoolcode" name="schoolcode" value="<?php echo $row["schoolcode"];?>" readonly hidden>
            

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Subject" value="<?php echo $row["subject"] ?>" readonly><br><br>

            

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


            <input type="submit" value="UPDATE" name="editRequest"   onclick="document.getElementsByClassName('editRequest').style.display='none'  " >
            
            
            

  
         
            
            
            
        </form>
      
        
    </div>

    