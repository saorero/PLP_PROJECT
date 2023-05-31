

<?php

session_start();
include 'databaseconnect.php';
//checks if the user is logged in if not redirects to the login page ensures only logged in users can access the dashboard
if(!isset($_SESSION["teacher"])){
    header("Location: teacher_login.php");
}


if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: teacher_login.php");
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
  
    <title>Teacher Dashboard</title>
    <?php 
    //ensures only logged in users can access the dashboard
 
    //checks if the user is logged in if not redirects to the login page
    if(!isset($_SESSION["teacher"])){
        header("Location: teacher_login.php");
    }

    
    ?>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
</head>
<body>
    <div class="minTop">
    
        <div class="minTople">

            <img src="./images/officialLogo.png" alt="notfound">
                <div class="try">
                
                <h3><i class="fa-solid fa-user-lock fa-1x"></i><?php echo "Teacher:". $_SESSION["teachername"];?></h3><br>
                <h3><?php echo  "Assigned:" .$_SESSION["gradeName"]  ; ?></h3><br>
                <h3><?php echo  "Class Id:"  .$_SESSION["classId"]  ; ?></h3><br>
            
                
                
                </div>
        
        </div>
        <div class="minTopre">
            <i class="fa-solid fa-landmark-flag fa-2x"> </i>
            <?php
            //PHP CODE THAT GETS THE SCHOOL NAME FROM THE created_schoolsmoe BASED ON THE SCHOOL CODE ENTERED BY THE USER


            
            ?>

            <!--SCHOOL NAME CAN BE DERIVED FROM A JOIN   -->
            
            <h3><?php echo   $_SESSION["schoolName"] ; ?></h3>

            <br>
            <form method="post">
                <input type="submit" name="logout" value="Logout" id="slogout">
            </form>
          
        </div>
        

    </div>
    
    <div class="main">
        <div class="choice">
            <ul>
            <li>    <h3><?php echo  "Total Students:"  .$_SESSION["totalStudents"]  ; ?></h3></li>
                <li><a href="#"><i class="fa-solid fa-calendar-days fa-2x"></i><?php echo  date("Y/m/d") ; ?></a></li>

                
                <li><i class="fa-solid fa-house-user fa-2x"></i><a href="teacherdashboard.php">Dashboard</a></li>
                <!--
                <li><i class="fa-solid fa-pen-to-square fa-2x"></i><a href="#">Class Distribution Inventory</a></li>
                -->
                <li><i class="fa-regular fa-clipboard fa-2x"></i><a href="class_inventory.php">Allocated Resources</a></li>
                
                <li><i class="fa-solid fa-book fa-2x"></i><a href="classrequest.php">Make Request</a></li>
                
            </ul>
            
        </div>
        <div class="graphs"> 
        <div class="chartBox" ><div id="tpiechart1"  ></div></div>
        <div class="chartBox"><div id="tpiechart2" ></div></div>
            
        </div>
    </div>

  <script type="text/javascript">
    //Code for charts
    //Chart 1 displays the received and not received requests that have been made for the class
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart(){

    
        //CHART 1 Displays ratio of the items the schools has received and not received from the ministry or any other supplier
        var data1 = google.visualization.arrayToDataTable([
          ['status', 'Count'],

          <?php
          $sql = "SELECT COUNT(*) AS total, SUM(CASE WHEN status = 'Received' THEN 1 ELSE 0 END) AS Received, SUM(CASE WHEN status = 'Not received' THEN 1 ELSE 0 END) AS Not_received FROM class_requests WHERE class_id =  '{$_SESSION["classId"]}' ";
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
        
        var options1 = {
          title: 'Class Request Allocation Ratio',
          colors:['#AF0069','#55B3B1'],
         
          backgroundColor: 'ecf2ff',
          
          shadow: '0px 4px 4px #82AAE3',
         is3D: true,
          width : 400,
          height : 400

        

        };
        var chart1 = new google.visualization.PieChart(document.getElementById('tpiechart1'));
        chart1.draw(data1, options1);


        //For Allocated Resources
        <?php
       $sql = "SELECT citemdesc, COUNT(*) as count FROM class_inventory WHERE class_id = '{$_SESSION["classId"]}' GROUP BY citemdesc";
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
            $data .= "['".$row['citemdesc']."', ".$percentage."],";
        }
        $data = rtrim($data, ","); // Remove the trailing comma
                ?>

        
      
var data2 = google.visualization.arrayToDataTable([
    <?php echo $data; ?>
]);

var options2 = {
    title: 'Item Distributed',
    colors:['#9C19E0', '#000D6B','#82AAE3'],
         
         backgroundColor: 'ecf2ff',
         
         shadow: '0px 4px 4px #82AAE3',
         is3D: true,
         width : 400,
         height : 400

};

var chart2 = new google.visualization.PieChart(document.getElementById('tpiechart2'));
chart2.draw(data2, options2);
}

  </script>
   
</body>
</html>



