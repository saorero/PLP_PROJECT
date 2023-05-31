

<?php

session_start();
include 'databaseconnect.php';
//checks if the user is logged in if not redirects to the login page ensures only logged in users can access the dashboard

if(!isset($_SESSION["schooladmin"])){
    header("Location: school_login.php");
}


if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: school_login.php");
    exit;
}


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
  <link href="moedashboard.css" rel="stylesheet">
  
    <title>School Dashboard</title>
    <?php 
    //ensures only logged in users can access the dashboard
 
    //checks if the user is logged in if not redirects to the login page
    if(!isset($_SESSION["schooladmin"])){
        header("Location: school_login.php");
    }

    
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
    
</head>
<body>
    <div class="minTop">
    
        <div class="minTople">

            <img src="./images/officialLogo.png" alt="notfound">
                <div class="try">
                
                <h3><i class="fa-solid fa-user-lock fa-1x"></i><?php echo  $_SESSION["schooladmin"];?></h3><br>
                <h3><?php echo  "School Admin:" .$_SESSION["adminName"]; ?></h3><br>
                <!--Code that displays total students in that school-->
                <?php
                  $sql = "SELECT SUM(totalstudents) AS totalst FROM classes WHERE schoolcode =  '{$_SESSION["schoolCode"]}' ";
                  $result_students= mysqli_query($con, $sql);
                  $row_students = mysqli_fetch_assoc($result_students);
                  $total_students = $row_students['totalst'];
                
                ?>
                <h3><?php echo  "Total Students:" .$total_students; ?></h3>

                </div>
        
        </div>
        <div class="minTopre">
            <i class="fa-solid fa-landmark-flag fa-2x"> </i>
            <?php
            //PHP CODE THAT GETS THE SCHOOL NAME FROM THE created_schoolsmoe BASED ON THE SCHOOL CODE ENTERED BY THE USER


            
            ?>

            <!--SCHOOL NAME CAN BE DERIVED FROM A JOIN   -->
            <h3><?php echo  $_SESSION["adminSchool"] ; ?> Dashboard</h3>

            <br>
            <form method="post">
                <input type="submit" name="logout" value="Logout" id="slogout">
            </form>
          
        </div>
        

    </div>
    
    <div class="main">
        <div class="choice">
            <ul>
                <li><a href="#"><i class="fa-solid fa-calendar-days fa-2x"></i><?php echo  date("Y/m/d") ; ?></a></li>
                <li><i class="fa-solid fa-house-user fa-2x"></i><a href="schooldashboard.php">Dashboard</a></li>
                
                <li><i class="fa-solid fa-school fa-2x"></i><a href="schoolclasses.php">Classes</a></li>
                <li><i class="fa-regular fa-clipboard fa-2x"></i><a href="school_inventory.php">School Inventory</a></li>
                <li><i class="fa-solid fa-pen-to-square fa-2x"></i><a href="shclassRequest.php">Class Requests</a></li>
                <li><i class="fa-solid fa-book fa-2x"></i><a href="schoolrequest.php">Make Request</a></li>
                
            </ul>
            
        </div>
        <div class="graphs"> 
        <div class="chartBox" ><div id="spiechart1"  ></div></div>
        <div class="chartBox"><div id="spiechart2" ></div></div>
        <div class="chartBox"><div id="spiechart3"></div></div>
        <div class="chartBox"><div id="spiechart4"></div></div>
            
        </div>
    </div>

  <!--CODE FOR CHARTS-->
  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart(){
        //CHART 1 Displays ratio of the items the schools has received and not received from the ministry or any other supplier
        var data1 = google.visualization.arrayToDataTable([
          ['status', 'Count'],

          <?php
          $sql = "SELECT COUNT(*) AS total, SUM(CASE WHEN status = 'received' THEN 1 ELSE 0 END) AS received, SUM(CASE WHEN status = 'notreceived' THEN 1 ELSE 0 END) AS notreceived FROM school_inventory WHERE schoolcode =  '{$_SESSION["schoolCode"]}' ";
          $result = $con->query($sql);

          if($result->num_rows>0) {
            $row = $result->fetch_assoc();
            $total = $row['total'];
            $received = $row['received'];
            $not_received = $row['notreceived'];
            $received_ratio = round(($received / $total) * 100);
            $not_received_ratio = round(($not_received / $total) * 100);
            echo "['Received', ".$received_ratio."],";
            echo "['Not Received', ".$not_received_ratio."],";
          }
        
          ?>
        ]);
        
        var options1 = {
          title: 'School Inventory Ratio',
          colors:['#576CBC','#9A208C'],
         
          backgroundColor: 'ecf2ff',
          
          shadow: '0px 4px 4px #82AAE3',
          is3D: true,
          width : 400,
          height : 300

        

        };
        var chart1 = new google.visualization.PieChart(document.getElementById('spiechart1'));
        chart1.draw(data1, options1);

          //CHART 2 //Displays ratio of class requests received and not received

          var data2 = google.visualization.arrayToDataTable([
          ['status', 'Count'],

          <?php
          $sql = "SELECT COUNT(*) AS total, SUM(CASE WHEN status = 'Received' THEN 1 ELSE 0 END) AS Received, SUM(CASE WHEN status = 'Not received' THEN 1 ELSE 0 END) AS Not_received FROM class_requests WHERE schoolcode =  '{$_SESSION["schoolCode"]}' ";
          $result = $con->query($sql);

          if($result->num_rows>0) {
            $row = $result->fetch_assoc();
            $total = $row['total'];
            $received = $row['Received'];
            $not_received = $row['Not_received'];
            $received_ratio = round(($received / $total) * 100);
            $not_received_ratio = round(($not_received / $total) * 100);
            echo "['Received', ".$received_ratio."],";
            echo "['Not Received', ".$not_received_ratio."],";
          }
        
          ?>
        ]);
        
        var options2 = {
          title: 'Class Request Allocation Ratio',
          colors:['#D21312','#070A52','#82AAE3'],
         
          backgroundColor: 'ecf2ff',
          
          shadow: '0px 4px 4px #82AAE3',
         is3D: true,
          width : 400,
          height : 300

        

        };
        var chart2 = new google.visualization.PieChart(document.getElementById('spiechart2'));
        chart2.draw(data2, options2);

        
        //CHART 3 that displays the ration of supplies gotten from diffrent suppliers
        //The values are gotten based on the school inventory that shows where items have been received from

        <?php
       $sql = "SELECT receivedfrom, COUNT(*) as count FROM school_inventory WHERE schoolcode = '{$_SESSION["schoolCode"]}' GROUP BY receivedfrom";
       $result = $con->query($sql);

       // Calculate the total count of all categories of suppliers
        $total_count = 0;
        while ($row = $result->fetch_assoc()) {
            $total_count += $row['count'];
        }
        // Create the data table with receivedFrom and percentage
        $data = "['Received From', 'Percentage'],";
        $result->data_seek(0); // Reset the result pointer to the beginning
        while ($row = $result->fetch_assoc()) {
            $percentage = round(($row['count'] / $total_count) * 100, 2);
            $data .= "['".$row['receivedfrom']."', ".$percentage."],";
        }
        $data = rtrim($data, ","); // Remove the trailing comma
                ?>

        
      
var data3 = google.visualization.arrayToDataTable([
    <?php echo $data; ?>
]);

var options3 = {
    title: 'Suppliers supply ratio',
    colors:['#0A4D68', '#D61355','#82AAE3'],
         
         backgroundColor: 'ecf2ff',
         
         shadow: '0px 4px 4px #82AAE3',
         is3D: true,
         width : 400,
         height : 300

};

var chart3 = new google.visualization.PieChart(document.getElementById('spiechart3'));
chart3.draw(data3, options3);
        
//CHART 4 Will display the ratio of stationerys the school orders frequently

<?php
       $sql = "SELECT itemdesc, COUNT(*) as count FROM school_inventory WHERE schoolcode = '{$_SESSION["schoolCode"]}' GROUP BY itemdesc";
       $result = $con->query($sql);

       // Calculate the total count of all categories of suppliers
        $total_count = 0;
        while ($row = $result->fetch_assoc()) {
            $total_count += $row['count'];
        }
        // Create the data table Item Desc and percentage
        $data = "['Item Desc', 'Percentage'],";
        $result->data_seek(0); // Reset the result pointer to the beginning
        while ($row = $result->fetch_assoc()) {
            $percentage = round(($row['count'] / $total_count) * 100, 2);
            $data .= "['".$row['itemdesc']."', ".$percentage."],";
        }
        $data = rtrim($data, ","); // Remove the trailing comma
                ?>

        
      
var data4 = google.visualization.arrayToDataTable([
    <?php echo $data; ?>
]);

var options4 = {
    title: 'Item Ordered',
    colors:['#9C19E0', '#000D6B','#82AAE3'],
         
         backgroundColor: 'ecf2ff',
         
         shadow: '0px 4px 4px #82AAE3',
         is3D: true,
         width : 400,
         height : 300

};

var chart4 = new google.visualization.PieChart(document.getElementById('spiechart4'));
chart4.draw(data4, options4);

    }//End of draw chart function

  


  </script>
   
</body>
</html>



