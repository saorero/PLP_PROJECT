<?php
session_start();



include 'databaseconnect.php';
//UPDATING SCHOOL INVENTORY
if(isset($_GET['sinventory_id'])){
  $sinventoryid=$_GET["sinventory_id"];
  $sql = "SELECT * FROM school_inventory WHERE sinventory_id='$sinventoryid'";
  $result = $con->query($sql);
  $row = $result->fetch_assoc();

  
  
}

if(isset($_POST["editsinv"])){

  $sinventoryid= trim($_POST['sinventory_id']);
  //$stscno= trim($_POST['stscno']);
  //$scode= trim($_POST['schoolcode']);
  $sitemdesc = trim($_POST['itemdesc']);

  $ssubject = trim($_POST['subject']);
  $sgrade = trim($_POST['grade']);

  $receivedfrom = trim($_POST['receivedfrom']);
  $squantity = trim($_POST['quantity']);
  //added now
  $sreceivedate = trim($_POST['receiveddate']);

  $sstatus = trim($_POST['status']);

  $sql = "UPDATE school_inventory
          SET itemdesc ='$sitemdesc', grade='$sgrade', receivedfrom ='$receivedfrom' ,quantity ='$squantity' , receiveddate=' $sreceivedate',status = '$sstatus' WHERE sinventory_id = '$sinventoryid' ";

if ($con->query($sql) === TRUE) {


  header("Location: school_inventory.php");
  echo "Request updated successfully";
 


  
} else {
  echo "Error updating record: " . $con->error;
}         

}

?>

<!--UPDATING SCHOOL INVENTORY-->

<link href="inventoryregion.css" rel="stylesheet">
    <title>Edit School Inventory</title>  

<div class="editsinv" id="editsinv">
        <form action="" method="POST">

            <span onclick="document.getElementById('editsinv').style.display='none'; " 
            
            id="close"><a href="school_inventory.php">&times;</a> </span> 
             
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Update Inventory</h3><br>

            <input type="hidden" name= "sinventory_id" value="<?php echo  $row["sinventory_id"];  ?>">
         
           


            <input type="text" id="schoolcode" name="schoolcode" value="<?php echo $row["schoolcode"];?>" readonly hidden><br><br>
           
            

            <label for="subject">Item Description</label>
            <input type="text" id="itemdesc" name="itemdesc"  value="<?php echo $row["itemdesc"] ?>" readonly><br><br>

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject"  value="<?php echo $row["subject"] ?>" readonly><br><br>

            <label for="grade">Grade</label>
            <select id="grade" name="grade" value="<?php echo $row["grade"]; ?>">
                <option value="" disabled selected>Grade</option>
                <option value="Grade1"   <?php  if($row['grade']=="Grade1"){echo "selected"; } ?>>Grade 1</option>
                <option value="Grade2"   <?php  if($row['grade']=="Grade2"){echo "selected"; } ?>>Grade 2</option>
                <option value="Grade3"   <?php  if($row['grade']=="Grade3"){echo "selected"; } ?>>Grade 3</option>
                <option value="Grade4"   <?php  if($row['grade']=="Grade4"){echo "selected"; } ?>>Grade 4</option>
                <option value="Grade5"   <?php  if($row['grade']=="Grade5"){echo "selected"; } ?>>Grade 5</option>
                <option value="Grade6"   <?php  if($row['grade']=="Grade6"){echo "selected"; } ?>>Grade 6</option>
                <option value="Grade7"   <?php  if($row['grade']=="Grade7"){echo "selected"; } ?>>Grade 7</option>
                <option value="Grade8"   <?php  if($row['grade']=="Grade8"){echo "selected"; } ?>>Grade 8</option>
                <option value="Grade9"   <?php  if($row['grade']=="Grade9"){echo "selected"; } ?>>Grade 9</option>
            </select><br><br>

       
            

            <label for="rfrom">Received From</label>
            <input id="rfrom"  name="receivedfrom" value="<?php echo $row["receivedfrom"]; ?>">

       
            <br><br>

            <label for="quantity">Quantity</label>
            <input id="quantity"  name="quantity" value="<?php echo $row["quantity"]; ?>">

       
            <br><br>

            <label for="receiveddate">Date Received <input type="date" id="receiveddate" name="receiveddate" placeholder="receiveddate"></label>
           <br><br>
           
           <label for="status">Status</label>
           <select id="status" name="status" >
                <option value="" disabled selected>Status</option>
                <option value="received"   <?php  if($row['status']=="received"){echo "selected"; } ?>>Received</option>

                <option value="notreceived"   <?php  if($row['status']=="notreceived"){echo "selected"; } ?>>Not received</option>
               
            </select><br><br>


            <input type="submit" value="UPDATE" name="editsinv"   onclick="document.getElementsByClassName('editsinv').style.display='none'  " >
            
            
            
        </form>
      
        
    </div>
