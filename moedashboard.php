
<?php
//ADDED
session_start();
include 'databaseconnect.php';
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
  
  
    <title>Ministry Dashboard</title>
    <?php 
    //ensures only logged in users can access the dashboard
 
    //checks if the user is logged in if not redirects to the login page
    if(!isset($_SESSION["moeuser"])){
        header("Location: ministry_login.php");
    }

    
    ?>
    
   
    <!--Code for displaying the charts HEAD-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
   
    
</head>
<body>
    <div class="minTop">
    
        <div class="minTople">

            <img src="./images/officialLogo.png" alt="notfound">
                <div class="try">
                
                <h3><i class="fa-solid fa-user-lock fa-1x"></i><?php echo  $_SESSION["moeuser"];?></h3><br>
                
                <h3><?php echo  $_SESSION["userName"] ; ?></h3>
                </div>
        
        </div>
        <div class="minTopre">
            <i class="fa-solid fa-landmark-flag fa-2x"> </i>
            <h3><?php echo   $_SESSION["countyName"] ; ?>  County MOE Dashboard</h3>
           

            <button class="logout"><a href="logout.php">Logout</a></button>
          
        </div>
        

    </div>
    
    <div class="main">
        <div class="choice">
            <ul>
                <li><a href="#"><i class="fa-solid fa-calendar-days fa-2x"></i><?php echo  date("Y/m/d") ; ?></a></li>
                <li><i class="fa-solid fa-house-user fa-2x"></i><a href="moedashboard.php">Dashboard</a></li>
                
                <li><i class="fa-solid fa-school fa-2x"></i><a href="moeschools.php">Schools</a></li>
                <li><i class="fa-regular fa-clipboard fa-2x"></i><a href="inventory_region.php">Regions Inventory</a></li>
                <li><i class="fa-solid fa-pen-to-square fa-2x"></i><a href="#" onclick="allRequest()">Requests</a></li>
                
            </ul>
            
        </div>
        <div class="graphs"  id="mainsection"> 
        <div class="chartBox" ><div id="piechart1"  ></div></div>
        <div class="chartBox"><div id="piechart2" ></div></div>
        <div class="chartBox"><div id="piechart3"></div></div>
        <div class="chartBox"><div id="piechart4"></div></div>
           
            
        </div>
    </div>

    <!--This only display all the requests for that particular county regardless of the school-->
    
    <div id="all_request" >

<!--THE VARIOUS COMMANDS-->
<div id="btnsRequest">
    <button class= "allrequest" id="allrequest" onclick="allRequest()"><a>All Requests</a></button>
<button class="received_requests" id="received_requests" onclick="receivedrequest()" ><a>Received Requests</a></button>
<button class="notreceived_requests" id="notreceived_requests" onclick="notreceivedRequest()" ><a>Not-Received Requests</a></button>

</div>

    <br><h2><?php echo   $_SESSION["countyName"] ; ?> School Requests</h2><br>

<!--ALL REQUESTS-->
     <table id="moeRequesttable">
            <thead>
            <tr class="headings">
                
                <th>Request Id</th>
                <th>School Code</th>
                <th>Item Description</th>
                <th>Subject</th>
                <th>Grade</th>
                
                <th>Quantity</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Action</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
            //Displays all the values in the request database based on the specific county code
        
           
            $sql = "SELECT * FROM schoolrequests WHERE countycode  =  '{$_SESSION["countyCode"]}' ";
                $result = $con->query($sql);
                if($result->num_rows>0) {
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td > $row[request_id] </td>
                            <td>$row[schoolcode]</td>
                            <td>$row[itemdesc]</td>
                            

                            <td>$row[subject]</td>
                            <td>$row[grade]</td>
                          
                            <td>$row[quantity]</td>
                            <td>$row[requestdate]</td>
                            <td>$row[status]</td>
                            <td>
                            <a role='button' href='editRequest.php?request_id=$row[request_id]' class='controls'>Edit</a>
                

                            </td>

                        </tr>

                        ";
                    }
                }
               // $con->close();
                
            
            ?>
     
      
        </tbody>
        </table>



    </div>

      <!--FOR RECEIVED REQUESTS-->
    <table id="receivedTable">
            <thead>
            <tr class="headings">
                
                <th>Request Id</th>
                <th>School Code</th>
                <th>Item Description</th>
                <th>Subject</th>
                <th>Grade</th>
                
                <th>Quantity</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Action</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
            //Displays all the values in the request database based on the specific county code
        
           
            $sql = "SELECT * FROM schoolrequests WHERE countycode  =  '{$_SESSION["countyCode"]}' AND  status = 'Received' ";
                $result = $con->query($sql);
                if($result->num_rows>0) {
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[request_id] </td>
                            <td>$row[schoolcode]</td>
                            <td>$row[itemdesc]</td>
                            

                            <td>$row[subject]</td>
                            <td>$row[grade]</td>
                          
                            <td>$row[quantity]</td>
                            <td>$row[requestdate]</td>
                            <td>$row[status]</td>
                            <td>
                            <a role='button' href='editRequest.php?request_id=$row[request_id]' class='controls'>Edit</a>
                

                            </td>

                        </tr>

                        ";
                    }
                }
            
            
            ?>
     
      
        </tbody>
        </table>

        <!--NOT RECEIVED REQUESTS-->
        

 <table id="notreceivedTable">
            <thead>
            <tr class="headings">
                
                <th>Request Id</th>
                <th>School Code</th>
                <th>Item Description</th>
                <th>Subject</th>
                <th>Grade</th>
                
                <th>Quantity</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Action</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
            //Displays all the values in the request database based on the specific county code 'for the ministry
        
           
            $sql = "SELECT * FROM schoolrequests WHERE countycode  =  '{$_SESSION["countyCode"]}' AND  status = 'Not received' ";
                $result = $con->query($sql);
                if($result->num_rows>0) {
            //outputs data for each row in the inventory
                    while($row=$result->fetch_assoc()){

                        echo"
                        <tr>
                            <td style=' padding: 15px;'> $row[request_id] </td>
                            <td>$row[schoolcode]</td>
                            <td>$row[itemdesc]</td>
                            

                            <td>$row[subject]</td>
                            <td>$row[grade]</td>
                          
                            <td>$row[quantity]</td>
                            <td>$row[requestdate]</td>
                            <td>$row[status]</td>
                            <td>
                            <a role='button' href='editRequest.php?request_id=$row[request_id]' class='controls'>Edit</a>
                

                            </td>

                        </tr>

                        ";
                    }
                }
            
              
            
            ?>
     
      
        </tbody>
        </table>
  
  <!--Function to replace the graphs and shows the requests-->
  <script>

        
    function allRequest(){
        let mainPart = document.getElementById("mainsection");
        let  listenRequest = document.getElementById("all_request");
        
      
        mainPart.style.display ="none";
        listenRequest.style.display = "block";

        let allTable = document.getElementById("moeRequesttable");
        allTable.style.display = "block";

        let receiveRequest = document.getElementById("receivedTable");
        receiveRequest.style.display = "none";
        console.log("Hello World");


    }
    function receivedrequest(){
        console.log("Hello World ")
        let receiveRequest = document.getElementById("receivedTable");
        receiveRequest.style.display = "block";

        let  listenRequest = document.getElementById("all_request");
        listenRequest.style.display = "block";

        let allTable = document.getElementById("moeRequesttable");
        allTable.style.display = "none";

        let notreceived = document.getElementById("notreceivedTable");
        notreceived .style.display = "none";

    }
   function notreceivedRequest(){
        console.log("Hello World ")
        let receiveRequest = document.getElementById("receivedTable");
        receiveRequest.style.display = "none";

        let  listenRequest = document.getElementById("all_request");
        listenRequest.style.display = "block";

        let allTable = document.getElementById("moeRequesttable");
        allTable.style.display = "none";

         let notreceived = document.getElementById("notreceivedTable");
        notreceived .style.display = "block";



    }


  </script>

<!--Code For Charts-->

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

       
        //CHART 1 shows the received and not received
        var data1 = google.visualization.arrayToDataTable([
          ['status', 'Count'],

          <?php
          $sql = "SELECT COUNT(*) AS total, SUM(CASE WHEN status = 'received' THEN 1 ELSE 0 END) AS received, SUM(CASE WHEN status = 'notreceived' THEN 1 ELSE 0 END) AS notreceived FROM moe_inventory WHERE civilservant_id =  '{$_SESSION["moeuser"]}' ";
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
          title: 'Regions Allocation Inventory',
          colors:['#03C4A1','#150485'],
         
          backgroundColor: 'ecf2ff',
          
          shadow: '0px 4px 4px #82AAE3',
          is3D: true,
          width : 400,
          height : 300

        

        };
        var chart1 = new google.visualization.PieChart(document.getElementById('piechart1'));
        chart1.draw(data1, options1);
       
        //CHART 2
       
        var data2 = google.visualization.arrayToDataTable([
        ['grade', 'quantity'],

        <?php
        $sql = "SELECT grade, SUM(quantity) AS total_quantity FROM moe_inventory WHERE civilservant_id = '{$_SESSION["moeuser"]}' GROUP BY grade";
        $result = $con->query($sql);

        if($result->num_rows > 0) {
                 
          //outputs data for each row in the inventory
          while($row = $result->fetch_assoc()){
            echo "['".$row['grade']."', ".$row['total_quantity']."],";
          }
        }
        ?>
      
      ]);

      var options2 = {
        title: 'Grade Ordered Quantities',
        colors:['#781C68','#3E54AC','#43D8C9','#95389E','#898AA6','#A85CF9'],
       
        backgroundColor: 'ecf2ff',
        
        shadow: '0px 4px 4px #82AAE3',
        is3D: true,
        width : 400,
        height : 300
      };
      var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));
      chart2.draw(data2, options2);

      //CHART 3
        


        <?php
       $sql = "SELECT subject, COUNT(*) as count FROM moe_inventory WHERE civilservant_id = '{$_SESSION["moeuser"]}' GROUP BY subject";
       $result = $con->query($sql);

       // Calculate the total count of all subjects
        $total_count = 0;
        while ($row = $result->fetch_assoc()) {
            $total_count += $row['count'];
        }
        // Create the data table with subject and percentage
        $data = "['Subject', 'Percentage'],";
        $result->data_seek(0); // Reset the result pointer to the beginning
        while ($row = $result->fetch_assoc()) {
            $percentage = round(($row['count'] / $total_count) * 100, 2);
            $data .= "['".$row['subject']."', ".$percentage."],";
        }
        $data = rtrim($data, ","); // Remove the trailing comma
                ?>

        
      
     /* ]);*/

      // Draw the pie chart using the data table and options
var data3 = google.visualization.arrayToDataTable([
    <?php echo $data; ?>
]);

var options3 = {
    title: 'Distributed subject proportion',
    colors:['#F94A29', '#D61355','#82AAE3'],
         
         backgroundColor: 'ecf2ff',
         
         shadow: '0px 4px 4px #82AAE3',
         is3D: true,
         width : 400,
         height : 300

};

var chart3 = new google.visualization.PieChart(document.getElementById('piechart3'));
chart3.draw(data3, options3);



  
         
      
    }
</script>



</body>
</html>


