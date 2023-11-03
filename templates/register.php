<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <script type="text/javascript">
        function addBox(){
            if (document.getElementById('Employee?').checked) {
                document.getElementById('area').style.display = 'block';
             } else {
                document.getElementById('area').style.display = 'none';
         }
        }
    </script>
    <link rel="stylesheet" href="style.css">
   <style>
        body {
        color: #46b35e;
        }
        html {
            background-color: #88D498;
            height:100%;
    
        }
    </style> 
    <head>
        <meta charset="utf-8">
        <title>Create an Account</title>
    </head>
    
    <div class="area">
        <ul class="anim">
            <li>
                <img src="icons/leftTruck.png" style="scale: 17%; position: absolute; bottom: -380px; left: -500px">
            </li>
            <li>
                <img src="icons/truck.png" style="scale: 17.3%; position: absolute; bottom: -380px; left: -500px">
            </li>
            <li>
                <img src="icons/truck.png" style="scale: 17.3%; position: absolute; bottom: -380px; left: -500px">
            </li>
            
        </ul>
        <div style="z-index: 0;position: absolute; bottom: 8%; width: 100%; height: 70px; background-color: #403f3c"></div>
        <div style="z-index: 0;position: absolute; bottom: 8%; width: 100%; height: 35px; background-color: #403f3c; border-top: dashed yellow 3px;"></div>
    </div >

    <body>
        
		<div class= "top-screen">
			<a style = "margin: auto; color: blue;" href="./home.php" class="logo">
				<img style = "height: 10vh" src="../icons/food-dark.png">
			</a>
		</div>
        <div class = "center-screen">
            <div class = "card" style="text-align: center;">
              <h1 style= "text-align: center; margin-top: 10px; margin-bottom: 80px;">
                  Create an Account
                </h1>
             
                <h3 style="color: red;"> <?php
                if (isset($_SESSION["signup_error"])) {
                    echo $_SESSION["signup_error"] . " please try again.";
                } 

                ?></h3> <br>

              <form method="post" action="../routes/process_register.php" name="myForm">
                <input class= "inputField" style="text-indent: 10px" placeholder="Create Username" type="text" name="username" required>
                
                <br><br>

                <input class= "inputField" style="text-indent: 10px" placeholder="Create Password" type="password" id="pwd" name="password" required>
                
                <br><br>

                <input class= "inputField" style="text-indent: 10px" placeholder="Confirm Password" type="password" id="pwd2" name="password2" required>
                <br><br>
                <div style="text-align: left; text-indent: 30px;">
                    <label class="container">
                        <input type="checkbox" id="Employee?" onclick="addBox();">
                        <span class="checkmark"></span>
                        New Employee?
                      </label>
                </div>
                <br>
                <div id="area" style="display: none;">
                    <input class= "inputField" style="text-indent: 10px" placeholder="Enter Masterkey" type="password" name="Masterkey">
                    <br><br>
                </div>
                <div style="text-align: center">
                    <input type="submit" class="inputField" value="Create Account" id = "submitButton">
                    <br>
                    <br>
                    Already have an account? 
                    <a href="login.php">Login here!</a>
            </form>
          </div>
          </div>
               
      
        

       
    </body>
</html>
