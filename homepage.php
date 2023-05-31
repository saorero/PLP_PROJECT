<?php
//Code for Inserting Queries

include 'databaseconnect.php';
if(isset($_POST["submit"])){
  $email= trim($_POST['email']);
  $message= trim($_POST['message']);


  $stmt=$con->prepare("INSERT INTO customerservice (email, messages) VALUES (?, ?)");

         

            $stmt->bind_param("ss", $email, $message );

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Message Delivered";
                header("Location: homepage.php");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
}



?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
      integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
   
    <link rel="stylesheet" href="homepage.css">
    <title>Homepage</title>
    
    
  </head>
  <body>
    
      <header>
        <div class="topnav">
          <div class="logo">
            <img src="./images/officialLogo.png" alt="not found" class="icon"/>
          </div>
          <div>
            <ul class="navlinks">
              <li><a href="homepage.php">HOME</a></li>
              <li><a href="#section2">ABOUT US</a></li>
              <li><a href="#contactus">CONTACT US</a></li>
              <li><a href="#section4">FAQS</a></li>
              <li><a href="#" onclick="document.getElementById('userchoice').style.display='block'">LOGIN</a></li>
              <li><a href="#" onclick="document.getElementById('userchoiceSign').style.display='block'">SIGN UP</a></li>
            </ul>

          </div>
         
          
          <div id="menu">

            <ul class="sidelinks">
              <li><a href="homepage.php">HOME</a></li>
              <li><a href="#section2">ABOUT US</a></li>
              <li><a href="#contactus">CONTACT US</a></li>
              <li><a href="#section4">FAQS</a></li>
              <li><a href="#" onclick="document.getElementById('userchoice').style.display='block'">LOGIN</a></li>
              <li><a href="#" onclick="document.getElementById('userchoiceSign').style.display='block'">SIGN UP</a></li>
            </ul>
          </div>
          <i onclick="sidemenu()" class="fa-solid fa-bars fa-2x" id="barline"></i>
          <i onclick="closing()" class="fa-solid fa-xmark fa-2x" id="closeline"></i>
        </div>

       
      </header>
      <!--MAIN SECTION OF THE SITE-->
      <main>
        <section id="section1">

          <div class="brief">
            <p>
              Keep tabs of each educational school material supplied from anywhere.Bringing transparency to you.
            </p>
          </div>
          <div class="image_container">
            <img
              src="./images/smilingchild.jpg"
              alt="not found"
              class="front_image"
            />
          </div>
        </section>

        <section id="section2">
          
            <h3>What we do</h3>
         
          
          
            <div class="cards">
              <div class="card">
                <img src="./images/readingst.jpg" alt="not found" >
                <p>Assist the ministry to keep track of the distributed textbooks within different  regions.</p>
              </div>
              <div class="card">
                <img src="./images/bkscollection.jpg" alt="not found" >
                <p>Keep records of distributed supplies within the school.</p>
              </div>
              <div class="card">
                <img src="./images/african classroom.jpg" alt="not found" >
                <p>Tracking each educational material within the school.</p>
              </div>
              <div class="card">
                <img src="./images/standinggirl.jpg" alt="not found" >
                <p>Ensuring proper distribution of books through proper record keeping.</p>
              </div>
              <div class="card">
                <img src="./images/smilingchild.jpg" alt="not found">
                <p>Transparency in the supply and distribution of educational materials to schools.</p>
              </div>
               
              
            </div>
          
          </section>

        <section id="section3">
            <div class="find">
              <img src="./images/finding.png" alt="not found">

            </div>

            <div class="quiz">
              <p>Are you an administrator, MOE official? Tracking has never been made easy join us today.</p>
              <button type="button" class="start"><a href="#">Get Started</a></button>
            </div>
            
        </section>
      <section id="section4">
        <div class="faq_box">
          <h2>FAQs</h2><br>
          <hr><br>
          <h4>Who can use Track Me?</h4>
          <p>School Administrators, Teachers and MOE Officials.</p>
          <br><h4>Do you need to have an account?</h4>
          <p>Yes, Sign Up depending on your user role.</p>
          <br><h4>How do i keep track of a single educational material?</h4>
          <p>Input the barcode of the item you are searching for on the search field.</p>
          <br><h4>I cant Sign Up on the teacher user role?</h4>
          <p>Ensure your TSC number has been registered under a class by the school.</p>
        </div>

      </section>
      </main>

      <footer>
        <div class="contacts">
          <div class="fcontacts" id="contactus"> 
            <p>Contact Us</p><br>
            <p><i class="fa-regular fa-envelope fa-2x"></i><t></t>traker@gmail.com</p><br>
            <p><i class="fa-solid fa-phone fa-2x"></i>+254788822187</p>
          </div>
          <div class="fform">
            <form action="#" method="post">
              <h4>Talk To Us</h4><br>
              <label for="email">Email</label><br>
              <input type="email" id="email" name="email"><br>
              <label for="message">Message</label><br>
              <textarea id="message" rows="4" cols="30" name="message"></textarea>
              <button type="submit" name="submit">Send</button>
            </form>
          </div>
        </div>
        
        <div class="socials">
          <div >
            <a href="#"><i class="fa-brands fa-twitter fa-fade fa-3x "></i></a>
            <a href="#"><i class="fa-brands fa-linkedin fa-fade fa-3x"></i></a>
            <a href="#"><i class="fa-brands fa-instagram fa-fade fa-3x"></i></a>
            <a href="#"><i class="fa-brands fa-facebook fa-fade fa-3x"></i></a>
          </div>
          <p>Copyright © 2023 Trackme -All right reserved.</p>
        </div>
      </footer>
      <!--Section that entails the users choice-->

      <div id="userchoice">


        <form action="#" method="POST">
            
            <span onclick="document.getElementById('userchoice').style.display='none'" id="cancel"> &times;</span>
            
           
            <i class="fa-solid fa-person-circle-question fa-3x"></i>
            <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" class="logo2">
            <i class="fa-solid fa-person-circle-question fa-3x"></i><br><br>
          
            <p>Select Your User Role.</p><br>
            <input type="radio" id="moe" name="user_role" value="ministry_login" onclick="directing()">
            <label for="moe">Ministry Of Education Official</label><br><br>

            <input type="radio" id="school" name="user_role" value="school_login" onclick="directing()">
            <label for="school">School Administrator</label><br><br>

            <input type="radio" id="ct" name="user_role" value="teacher_login" onclick="directing()" >
            <label for="ct">Class Teacher</label>
    
            
            
        </form>
        
    </div>


    <!--SIGN UP-->
    <div id="userchoiceSign">


      <form action="#" method="POST">
          
          <span onclick="document.getElementById('userchoiceSign').style.display='none'" id="cancel"> &times;</span>
          
         
          <i class="fa-solid fa-person-circle-question fa-3x"></i>
          <img src="./images/Track_Me_Logo-01-removebg-preview.png" alt="not found" class="logo2">
          <i class="fa-solid fa-person-circle-question fa-3x"></i><br><br>
        
          <p>Select your User Role</p><br>
          <input type="radio" id="moe" name="userRole" value="ministry_signup" onclick="directing2()">
          <label for="moe">Ministry Of Education Official</label><br><br>

          <input type="radio" id="school" name="userRole" value="school_signup" onclick="directing2()">
          <label for="school">School Administrator</label><br><br>

          <input type="radio" id="ct" name="userRole" value="teacher_signup" onclick="directing2()" >
          <label for="ct">Class Teacher</label>
  
          
          
      </form>
      
  </div>


    
   <script>
    let openmenu = document.getElementById('barline');
    let closemenu = document.getElementById('closeline');
    let smenu = document.getElementById('menu');

    function sidemenu(){
   
    openmenu.style.display = "none";
    smenu.style.display = "block";
    closemenu.style.display = "block";


    
   
    }
    function closing(){
      console.log("Hello")
     
      openmenu.style.display = "block";
    smenu.style.display = "none";
    closemenu.style.display = "none";
    }
    //scripts for the pop up modal form
    function directing(){
        let selected = document.querySelector('input[name="user_role"]:checked');
        if(selected){
            window.location.href = selected.value + '.php';
        }
    }
    

    function directing2(){

        let selected = document.querySelector('input[name="userRole"]:checked');
        if(selected){
            window.location.href = selected.value + '.php';
        }
    }
   </script>

   
   
  </body>
</html>
