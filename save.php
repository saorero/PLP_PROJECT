$stmt=$con->prepare("INSERT INTO moe_inventory (inventory_id, civilservant_id, schoolcode, itemdesc, subject,grade, itemcode, quantity, daterequested,
            datedisbursed, receiveddate, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

         

            $stmt->bind_param("sssssssissss", $inventoryid, $civilid, $scode,$itemdesc, $subject, $grade, $itemcode, 
            $quantity,  $daterequested, $datedisbursed, $datereceived ,$status );

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Record Added";
                header("Location: inventory_region.php");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();


        
            /*if($_SERVER['REQUEST_METHOD'] == 'GET' ){
    $inventory_id = $_GET["inventory_id"];
    $sql = "SELECT * FROM moe_inventory WHERE inventory_id = $inventory_id ";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    
$inventoryid= $row['inventory_id'];
$civilid= $row['civilservant_id'];
$scode= $row['schoolcode'];
$itemdesc = $row['itemdesc'];

$subject = $row['subject'];
$grade = $row['grade'];

$itemcode = $row['itemcode'];
$quantity = $row['quantity'];
$daterequested = $row['daterequested'];
$datedisbursed = $row['datedisbursed'];
$datereceived =$row['receiveddate'];
$status = $row['status'];
    
}

//Updates
if($_SERVER['REQUEST_METHOD'] == 'POST' ){

    $inventoryid= $_POST['inventory_id'];
$civilid=  $_POST['civilservant_id'];
$scode=  $_POST['schoolcode'];
$itemdesc =  $_POST['itemdesc'];

$subject =  $_POST['subject'];
$grade =  $_POST['grade'];

$itemcode =  $_POST['itemcode'];
$quantity =  $_POST['quantity'];
$daterequested =  $_POST['daterequested'];
$datedisbursed =  $_POST['datedisbursed'];
$datereceived = $_POST['receiveddate'];
$status =  $_POST['status'];

}



$sql = "UPDATE moe_inventory
            SET itemdesc = '$itemdesc', subject = '$subject',grade = '$grade',itemcode = '$itemcode',quantity = '$quantity', daterequested = '$daterequested', datedisbursed = '$datedisbursed',receiveddate = '$datereceived',status = '$status' WHERE inventory_id = $inventoryid ";

            $result = $con->query($sql);*/