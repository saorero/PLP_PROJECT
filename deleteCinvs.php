
<?php

include 'databaseconnect.php';




if(isset($_GET['cinventoryid'])){
    $inventoryid=$_GET["cinventoryid"];
    $sql = "DELETE FROM class_inventory WHERE cinventoryid='$inventoryid'";
    $result = $con->query($sql);

    if($result==TRUE){

        
     header("Location: schoolclasses.php");
        //echo "Deleted";
      //  exit;
        
    
    
    }
    

}
?>


