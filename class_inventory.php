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
   
    
    <title>Class Inventory</title>

    
    <?php 
        include 'databaseconnect.php';
    //ensures only logged in users can access the dashboard :: checks if the user is logged in if not redirects to the login page

    if(!isset($_SESSION["teacher"]) ){
        header("Location: teacher_login.php");
    }

    

    //Inserting values into the class inventory
    if(isset($_POST["submit"])){//the code inside will work only when  submit has been initiated

        $cinventoryid= trim($_POST['cinventory_id']);
        $teacher_id= trim($_POST['teacher_id']);
        $class_id= trim($_POST['class_id']);
        $citemdesc = trim($_POST['citemdesc']);

        $csubject = trim($_POST['subject']);
      
        $squantity = trim($_POST['quantity']);
       
        $sstatus = trim($_POST['status']);

        $errors = array();

        //DEFINING ERRORS

        if(empty($cinventoryid) OR empty($teacher_id) OR empty($class_id) OR empty($citemdesc)  OR empty($squantity) OR empty($sstatus)){
            array_push($errors,"Required Fields!");
        }

        //Checks whether the teacher_id is same as the session
        if ($teacher_id != $_SESSION["teacher"]){
            array_push($errors, "Enter the correct class teacher_id");
        }

     
        
        //Searching through the database to see if the inventory already exists
        $sql = "SELECT * FROM class_inventory WHERE cinventoryid = '$cinventoryid' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {

            array_push($errors,"Cannot re-enter an existing inventory id");

        }

        


        if(count($errors)>0){
            foreach ($errors as $error){
                echo $error;
            }
        }else{
            


            $sql = "INSERT INTO class_inventory(cinventoryid, teacher_id, class_id, citemdesc, subject,quantity, status) VALUES ('$cinventoryid', '$teacher_id', '$class_id','$citemdesc', '$csubject', '$squantity','$sstatus'  )";

            if ($con->query($sql) === TRUE) {
              
               echo "Record Added";
               header("Location: class_inventory.php");
             
            } else {
                echo "Error: " . $sqli . "<br>" . $con->error;
            }
               
        }

            

    } 
    

    

    
    ?>
    
   
</head>
<body onload="currentTimestamp()">

    <div class="minTop">
        <div class="minTople">
            <img src="./images/officialLogo.png" alt="notfound">
            <i class="fa-solid fa-circle-arrow-left fa-2x"></i><a href="teacherdashboard.php"> Back</a>
            
           
            
        </div>
        <div class="minTopre">

            <i class="fa-solid fa-landmark-flag fa-3x"></i>
            <div class="try">
       
            <h3><?php echo  "Assigned:" .$_SESSION["gradeName"]  ; ?></h3><br>

            <h3><?php echo  "Class Id:"  .$_SESSION["classId"]  ; ?></h3>

          

</div>
        </div>

    </div>
    <h1>Allocated Resources</h1> 
    <a href="#" role="button"  class="searchBt" onclick="document.getElementById('newrecord').style.display='block'"> New Entry</a>



    <input type="text" placeholder="Item Search" id="itemsearch"  onkeyup="itemSearch()"/> 
    
    <div class="list_inventory">
        
    
        <table id="moetable">
            <thead>
            <tr class="headings">
                
                <th>Inventory Id</th>
                
                <th>Item Description</th>
                <th>Subject</th>
                <th>Quantity</th>
                <th>Received Date</th>
                
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //Displaying the values in the database
            $sql = "SELECT * FROM class_inventory WHERE teacher_id = '{$_SESSION["teacher"]}' AND class_id = '{$_SESSION['classId']}'  ";
               
                $result = $con->query($sql);
                if($result->num_rows>0) {
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[cinventoryid] </td>
                            
                            <td>$row[citemdesc]</td>

                            <td>$row[subject]</td>
                            
                            <td>$row[quantity]</td>

                            <td>$row[received_date]</td>
                       
                            <td>$row[status]</td>
                            <td>
                            <a role='button' href='cinvEdit.php?cinventoryid=$row[cinventoryid]'class='controls'>Edit</a>

                            <a role='button' href='delete.php?cinventoryid=$row[cinventoryid]' class='controls'>Delete</a>
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
    <div id="newrecord" onload="currentTimestamp()">


        <form action="#" method="POST">
            
            <span onclick="document.getElementById('newrecord').style.display='none'" id="close"> &times;</span> 
            
           
           
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" >
            <h3>Received Resources</h3><br>
          
            <input type="text" id="cinventory_id" name="cinventory_id" placeholder="Inventory Id" required><br><br>
           <!--The default session variables are sent to the database instead of user inputting the elements-->
            <input type="text" id="teacher_id" name="teacher_id" value="<?php echo $_SESSION['teacher']; ?>" hidden>
            <input type="text" id="class_id" name="class_id" value="<?php echo $_SESSION['classId']; ?>" hidden>
            <!--Hidden values end here-->
           
            <input type="text" id="citemdesc" name="citemdesc" placeholder="Item Description" ><br><br>


            <input type="text" id="subject" name="subject" placeholder="Subject" ><br><br>
           
            <input type="number" id="quantity" name="quantity" placeholder="Item Quantity" required>
           <br><br>

           <label for="received_date">Date Received <input type="text" id="received_date" name="received_date" readonly ></label>

           <br><br>
            
            <select id="status" name="status" >
                <option value="" disabled selected>Status</option>
                <option value="received">Received</option>
                <option value="Not received">Not received</option>
               
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

    //A CODE THAT DISPLAYS THE CURRENT TIMESTAMP ON THE RECEIVED DATE INPUT
    function currentTimestamp(){
    console.log("Hello World")
    var currentDate = new Date();
        let timestamp = document.getElementById("received_date")
        let format ={
            timeZone:"Africa/Nairobi",
            year :"numeric",
            month :"2-digit",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit"


        }
        timestamp.value = currentDate.toLocaleString("en-US", format);
       
    }
   

    </script>
</body>
</html>