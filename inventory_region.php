<?php
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
   
    <link href="inventoryregion.css" rel="stylesheet"> 
   
    
    <title>Inventory</title>

    
    <?php 
        include 'databaseconnect.php';
    //ensures only logged in users can access the dashboard :: checks if the user is logged in if not redirects to the login page

    if(!isset($_SESSION["moeuser"])){
        header("Location: ministry_login.php");
    }

    //Inserting values into the ministry inventory
    if(isset($_POST["submit"])){//the code inside will work only when  submit has been initiated

        $inventoryid= trim($_POST['inventory_id']);
        $civilid= trim($_POST['civilservant_id']);
        $scode= trim($_POST['schoolcode']);
        $itemdesc = trim($_POST['itemdesc']);

        $subject = trim($_POST['subject']);
        $grade = trim($_POST['grade']);

        $itemcode = trim($_POST['itemcode']);
        $quantity = trim($_POST['quantity']);
        $daterequested = trim($_POST['daterequested']);
        $datedisbursed = trim($_POST['datedisbursed']);
        $datereceived = trim($_POST['receiveddate']);
        $status = trim($_POST['status']);
        $errors = array();

        //DEFINING ERRORS

        if(empty($scode) OR empty($civilid) OR empty($inventoryid) OR empty($itemcode)  ){
            array_push($errors,"Required Fields!");
        }

     
        
        //Searching through the database to see if the inventory already exists
        $sql = "SELECT * FROM moe_inventory WHERE inventory_id = '$inventoryid' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {

            array_push($errors,"Cannot re-enter an existing inventory id");

        }
        //Checks whether the one entering the details inventory is supposed to
        if($civilid != $_SESSION["moeuser"]){
            array_push($errors, "Enter a valid Employer_Id");
        }

  
        $sql ="SELECT countycode FROM created_schoolsmoe WHERE schoolcode = '$scode'";
        $result = $con->query($sql);
        $row = $result->fetch_assoc(); // extract the specific row from the result 
        $countycode = $row["countycode"]; // extract the countycode value from the row
        
        if ($countycode != $_SESSION["countyCode"]) {
            array_push($errors, "School Not Within your locality");
        }
        
        


        if(count($errors)>0){
            foreach ($errors as $error){
                echo $error;
            }
        }else{
            
          


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
               
        }

            

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
            <h3>Employer Id:<?php echo  $_SESSION["moeuser"] ; ?></h3>
        </div>

    </div>
    <h1>School Resource Allocation Inventory</h1> 
    <a href="#" role="button" onclick="document.getElementById('newrecord').style.display='block'" class="newinventory">New Entry</a>
    <input type="text" placeholder="Item Search" id="itemsearch"  onkeyup="itemSearch()"/> 
    
    <div class="list_inventory">
        
    
        <table id="moetable">
            <thead>
            <tr class="headings">
                
                <th>Inventory Id</th>
                <!--<th>Civil Servant Id</th>-->
                <th>School Code</th>
                <th>Item Description</th>
                <th>Subject</th>
                <th>Grade</th>
                <th>Item Code</th>
                <th>Quantity</th>
                <th>Date Requested</th>
                <th>Date Disbursed</th>
                <th>Received Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //Displaying the values from the database
           
            $sql = "SELECT * FROM moe_inventory WHERE civilservant_id = '{$_SESSION["moeuser"]}'";


               
                $result = $con->query($sql);
                if($result->num_rows>0) {
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[inventory_id] </td>
                            <td>$row[schoolcode]</td>
                            <td>$row[itemdesc]</td>

                            <td>$row[subject]</td>
                            <td>$row[grade]</td>
                            <td>$row[itemcode]</td>
                            <td>$row[quantity]</td>
                            <td>$row[daterequested]</td>
                            <td>$row[datedisbursed]</td>
                            <td>$row[receiveddate]</td>
                            <td>$row[status]</td>
                            <td>
                            <a role='button' href='edit.php?inventory_id=$row[inventory_id]' class='controls'>Edit</a>
                            <a role='button' href='delete.php?inventory_id=$row[inventory_id]' class='controls'>Delete</a>
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
    <!--FORM FOR ADDING NEW INVENTORY RECORDS-->
    <div id="newrecord">


        <form action="#" method="POST">
            
            <span onclick="document.getElementById('newrecord').style.display='none'" id="close"> &times;</span> 
            
           
           
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Enter Details</h3><br>
          
            <input type="text" id="inventory_id" name="inventory_id" placeholder="Inventory Id" required><br><br>

            <input type="text" id="civilservant_id" name="civilservant_id" value="<?php echo $_SESSION['moeuser']; ?>"  hidden>
            <input type="text" id="schoolcode" name="schoolcode" placeholder="Enter School Code"><br><br>
           
            <input type="text" id="itemdesc" name="itemdesc" placeholder="Item Description" ><br><br>


            <input type="text" id="subject" name="subject" placeholder="Subject" ><br><br>
            <select id="grade" name="grade" >
                <option value="" disabled selected>Grade</option>
                <option value="Grade1">Grade 1</option>
                <option value="Grade2">Grade 2</option>
                <option value="Grade3">Grade 3</option>
                <option value="Grade4">Grade 4</option>
                <option value="Grade5">Grade 5</option>
                <option value="Grade6">Grade 6</option>
                <option value="Grade7">Grade 7</option>
                <option value="Grade8">Grade 8</option>
                <option value="Grade9">Grade 9</option>
            </select><br><br>


            <input type="text" id="itemcode" name="itemcode" placeholder="Item code" required><br><br>
            <input type="number" id="quantity" name="quantity" placeholder="Item Quantity" required><br><br>
            <label for="daterequested">DateRequested<input type="date" id="daterequested" name="daterequested" required></label>
            <br><br>
            <label for="datedisbursed">Date Disbursed <input type="date" id="datedisbursed" name="datedisbursed" placeholder="datedisbursed"></label>
           <br><br>
           <label for="receiveddate">Date Received <input type="date" id="receiveddate" name="receiveddate" placeholder="receiveddate"></label>
           <br><br>
            
            <select id="status" name="status" >
                <option value="" disabled selected>Status</option>
                <option value="received">Received</option>
                <option value="notreceived">Not received</option>
               
            </select><br><br>

            
            <input type="submit" value="Add" name="submit"   onclick="document.getElementById('newrecord').style.display='none'">
            
    
            
            
        </form>
        
    </div>
   
    <!--JAVASCRIPT FOR ITEM SEARCH-->
    <script>
      //SEARCHING FUNCTION
    function itemSearch() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("itemsearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("moetable");
      tr = table.getElementsByTagName("tr");
    
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
</body>
</html>