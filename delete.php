

<?php
include 'databaseconnect.php';

session_start();


if(isset($_GET['inventory_id'])){
    $inventoryid=$_GET["inventory_id"];
    $sql = "DELETE FROM moe_inventory WHERE inventory_id='$inventoryid'";
    $result = $con->query($sql);
    if($result==TRUE){
        echo "Deleted";
        header("Location: inventory_region.php");
    }
    

}

if(isset($_GET['request_id'])){
    $request_id=$_GET["request_id"];
    $sql = "DELETE FROM schoolrequests WHERE request_id='$request_id'";
    $result = $con->query($sql);
    if($result==TRUE){
        echo "Deleted";
        header("Location: schoolrequest.php");
    }
    

}
if(isset($_GET['crequest_id'])){
    $request_id=$_GET["crequest_id"];
    $sql = "DELETE FROM class_requests WHERE crequest_id='$request_id'";
    $result = $con->query($sql);
    if($result==TRUE){
        echo "Deleted";
        header("Location: classrequest.php");
    }
    

}


//SCHOOL INVENTORY DELETE

if(isset($_GET['sinventory_id'])){
    $sinventory_id=$_GET["sinventory_id"];
    $sql = "DELETE FROM school_inventory WHERE sinventory_id='$sinventory_id'";
    $result = $con->query($sql);
    if($result==TRUE){
        echo "Deleted";
        header("Location: school_inventory.php");
    }
    

}
//DELETE CLASS ALLOCATION RECORD


if(isset($_GET['cinventoryid'])){
    $inventoryid=$_GET["cinventoryid"];
    $sql = "DELETE FROM class_inventory WHERE cinventoryid='$inventoryid'";
    $result = $con->query($sql);

    if($result==TRUE){

       // if (isset($_SESSION["teacher"])){
            header("Location: class_inventory.php");
        echo "Deleted";
      //  exit;
        
   // }
   
    }
    

}

?>