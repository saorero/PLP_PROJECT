<?php
include 'databaseconnect.php';
session_start();
/*if(!isset($_SESSION["moeuser"])){
    header("Location: ministry_login.php");
}*/

//CODE FOR EDITING

if(isset($_GET['inventory_id'])){
    $inventoryid=$_GET["inventory_id"];
    $sql = "SELECT * FROM moe_inventory WHERE inventory_id='$inventoryid'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    
    
}

if(isset($_POST["edit"])){
    
    $inventoryid= trim($_POST['inventory_id']);
    $civilid= trim($_POST['civilservant_id']) ;
    $scode= trim($_POST['schoolcode']) ;
    $itemdesc = trim($_POST['itemdesc']) ;
    
    $subject = trim($_POST['subject']) ;
    $grade = trim($_POST['grade']); 
    
    $itemcode =  trim($_POST['itemcode']);
    $quantity = trim( $_POST['quantity']);
    $daterequested = trim( $_POST['daterequested']);
    $datedisbursed =  trim($_POST['datedisbursed']);
    $datereceived = trim($_POST['receiveddate']);
    $status = trim($_POST['status']) ;

    $sql = "UPDATE moe_inventory
            SET inventory_id='$inventoryid', civilservant_id='$civilid',schoolcode='$scode' , itemdesc = '$itemdesc', subject = '$subject',grade = '$grade',itemcode = '$itemcode',quantity = '$quantity', daterequested = '$daterequested', datedisbursed = '$datedisbursed',receiveddate = '$datereceived',status = '$status' WHERE inventory_id = '$inventoryid' ";

if ($con->query($sql) === TRUE) {
  
    header("Location: inventory_region.php");
    echo "Record updated successfully";
    
  } else {
    echo "Error updating record: " . $con->error;
  }         

}

//END EDIT


            
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
    <title>Edit Inventory</title>

    
   
</head>
<body>

<!--Put it in such a way that it diplays the school name will be achieved throgh joins-->


    <div class="editrecord" id="edit">
        <form action="#" method="POST">

        <!--Xmark-->
            <span onclick="document.getElementById('edit').style.display='none'" id="close"><a href="inventory_region.php">&times;</a> </span> 
             
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Enter Details</h3><br>

            <input type="hidden" name= "inventory_id" value="<?php echo  $row["inventory_id"];  ?>">
         
            <input type="hidden" id="civilservant_id" name="civilservant_id" placeholder="MOE Id" value="<?php echo $row['civilservant_id'] ;?>" required>


            <label for="schoolcode">School Code</label>
            <input type="text" id="schoolcode" name="schoolcode" placeholder="Enter School Code"  value="<?php echo $row["schoolcode"]; ?>"><br><br>
           
            <label for="itemdesc">Item Description</label>
            <input type="text" id="itemdesc" name="itemdesc" placeholder="Item Description"  value="<?php echo $row["itemdesc"]; ?>"><br><br>

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Subject" value="<?php echo $row["subject"] ?>"><br><br>

            <label for="grade">Grade</label>
            <select id="grade" name="grade" >
                <option value="" disabled selected>Grade</option>
                <option value="Grade1" <?php  if($row['grade']=="Grade1"){echo "selected"; } ?> >Grade 1</option>
                <option value="Grade2"  <?php  if($row['grade']=="Grade2"){echo "selected"; } ?>>Grade 2</option>
                <option value="Grade3"  <?php  if($row['grade']=="Grade3"){echo "selected"; } ?>>Grade 3</option>
                <option value="Grade4"  <?php  if($row['grade']=="Grade4"){echo "selected"; } ?>>Grade 4</option>
                <option value="Grade5"  <?php  if($row['grade']=="Grade5"){echo "selected"; } ?>>Grade 5</option>
                <option value="Grade6"  <?php  if($row['grade']=="Grade6"){echo "selected"; } ?>>Grade 6</option>
                <option value="Grade7"  <?php  if($row['grade']=="Grade7"){echo "selected"; } ?>>Grade 7</option>
                <option value="Grade8"  <?php  if($row['grade']=="Grade8"){echo "selected"; } ?>>Grade 8</option>
                <option value="Grade9"  <?php  if($row['grade']=="Grade9"){echo "selected"; } ?>>Grade 9</option>
            </select><br><br>

            <label for="itemcode">Item Code</label>
            <input type="text" id="itemcode" name="itemcode" placeholder="Item code" value="<?php echo $row["itemcode"];?>" required><br><br>

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" placeholder="Item Quantity" value="<?php echo $row["quantity"]; ?>" required><br><br>
            <label for="daterequested">DateRequested<input type="date" id="daterequested" name="daterequested" value="<?php echo $row["daterequested"]; ?>" required></label>
            <br><br>
            <label for="datedisbursed">Date Disbursed <input type="date" id="datedisbursed" name="datedisbursed" placeholder="datedisbursed" value="<?php echo $row["datedisbursed"]; ?>"></label>
           <br><br>
           <label for="receiveddate">Date Received <input type="date" id="receiveddate" name="receiveddate" placeholder="receiveddate" value="<?php echo $row["receiveddate"]; ?>"></label>
           <br><br>
           <label for="status">Status</label>
            <select id="status" name="status" >
                <option value="" disabled selected>Status</option>
                <option value="received"  <?php  if($row['status']=="received"){echo "selected"; } ?>>Received</option>
                <option value="notreceived"  <?php  if($row['status']=="notreceived"){echo "selected"; } ?>>Not received</option>
               
            </select><br><br>

           
            <input type="submit" value="SAVE" name="edit"   onclick="document.getElementsByClassName('editrecord').style.display='none'">
            
    
            
            
        </form>
        
    </div>
    
   
  

</body>
</html>