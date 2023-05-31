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
   
    
    <title>School Inventory</title>

    
    <?php 
        include 'databaseconnect.php';
    //ensures only logged in users can access the dashboard :: checks if the user is logged in if not redirects to the login page

    if(!isset($_SESSION["schooladmin"])){
        header("Location: school_login.php");
    }

    //Inserting values into the ministry inventory
    if(isset($_POST["submit"])){//the code inside will work only when  submit has been initiated

        $sinventoryid= trim($_POST['sinventory_id']);
//HIDDEN FIELDS
        $stscno= trim($_POST['stscno']);
        $scode= trim($_POST['schoolcode']);
//end hiden fields
        $sitemdesc = trim($_POST['itemdesc']);

        $ssubject = trim($_POST['subject']);
        $sgrade = trim($_POST['grade']);

        $receivedfrom = trim($_POST['receivedfrom']);
        $squantity = trim($_POST['quantity']);
        $sreceivedate = trim($_POST['receiveddate']);
        $sstatus = trim($_POST['status']);

        $errors = array();

        //DEFINING ERRORS

        if(empty($scode) OR empty($stscno) OR empty($receivedfrom) OR empty($sstatus) OR empty($sitemdesc) OR empty($ssubject) OR empty($sgrade)){
            array_push($errors,"Required Fields!");
        }

     
        
        //Searching through the database to see if the inventory already exists
        $sql = "SELECT * FROM school_inventory WHERE sinventory_id = '$sinventoryid' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {

            array_push($errors,"Cannot re-enter an existing inventory id");

        }

        


        if(count($errors)>0){
            foreach ($errors as $error){
                echo $error;
            }
        }else{
            


            $sql = "INSERT INTO school_inventory(sinventory_id, tscno, schoolcode, itemdesc, subject,grade, receivedfrom, quantity, receiveddate, status) VALUES ('$sinventoryid', '$stscno', '$scode','$sitemdesc', '$ssubject', '$sgrade','$receivedfrom', '$squantity','$sreceivedate ','$sstatus'  )";

            if ($con->query($sql) === TRUE) {
              
               echo "Record Added";
               header("Location: school_inventory.php");
             
            } else {
                echo "Error: " . $sqli . "<br>" . $con->error;
            }
               
        }

            

    } 
    

    

    
    ?>
    
   
</head>
<body>

    <div class="minTop">
        <div class="minTople">
            <img src="./images/officialLogo.png" alt="notfound">
            <i class="fa-solid fa-circle-arrow-left fa-2x"></i><a href="schooldashboard.php"> Back</a>
           
            
        </div>
        <div class="minTopre">

            <i class="fa-solid fa-landmark-flag fa-2x"></i>
            <h3>Employer Id:<?php echo  $_SESSION["schooladmin"] ; ?></h3><br>
            <h3><?php echo  "=>".$_SESSION["adminSchool"] ; ?></h3>
        </div>

    </div>
    <h1>School Resource Inventory</h1> 
    <a href="#" role="button" class="newinventory"  onclick="document.getElementById('newrecord').style.display='block'">New Entry</a>
    <input type="text" placeholder="Item Search" id="itemsearch"  onkeyup="itemSearch()"/> 
    
    <div class="list_inventory">
        
    
        <table id="moetable">
            <thead>
            <tr class="headings">
                
                <th>Inventory Id</th>
                
                <th>Item Description</th>
                <th>Subject</th>
                <th>Grade</th>
                <th>Received From</th>
                <th>Quantity</th>
                <th>Received Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //Displaying the values in the database
            $sql = "SELECT * FROM school_inventory WHERE tscno = '{$_SESSION["schooladmin"]}' AND schoolcode = '{$_SESSION['schoolCode']}'  ";
               
                $result = $con->query($sql);
                if($result->num_rows>0) {
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[sinventory_id] </td>
                            
                            <td>$row[itemdesc]</td>

                            <td>$row[subject]</td>
                            <td>$row[grade]</td>
                            <td>$row[receivedfrom]</td>
                            <td>$row[quantity]</td>
                            <td>$row[receiveddate]</td>
                            <td>$row[status]</td>
                            <td>
                            <a role='button' href='editSinv.php?sinventory_id=$row[sinventory_id]'class='controls'>Edit</a>

                            <a role='button' href='delete.php?sinventory_id=$row[sinventory_id]' class='controls'>Delete</a>
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
    <div id="newrecord">


        <form action="#" method="POST">
            
            <span onclick="document.getElementById('newrecord').style.display='none'" id="close"> &times;</span> 
            
           
           
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Enter Details</h3><br>
          
            <input type="text" id="sinventory_id" name="sinventory_id" placeholder="Inventory Id" required><br><br>
            <!--HIDDEN FIELDS-->
            
            <input type="text" id="stscno" name="stscno" value="<?php echo $_SESSION['schooladmin']; ?>" hidden>

            <input type="text" id="schoolcode" name="schoolcode" value="<?php echo $_SESSION['schoolCode']; ?>" hidden>
            <!--END OF HIDDEN FIELDS-->
           
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


            <input type="text" id="receivedfrom" name="receivedfrom" placeholder="Received From" required><br><br>
            <input type="number" id="quantity" name="quantity" placeholder="Item Quantity" required>
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