<?php
session_start();
?>

<!DOCTYPE html>
<html style="background-color: var(--light-primary);" lang="en" dir="ltr">

  <link rel="stylesheet" href="style.css">

  <style>
    body {
      color: var(--light-primary);
    }

  </style>

  <!--ANIMATION-->

  <head>
      <link rel="shortcut icon" href="icons/grocery.ico"/>
      <meta charset="utf-8">
      <title>Login</title>
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
            <img style = "z-index: 1000; height: 10vh" src="../icons/food-dark.png">
        </a>
    </div>
<div class = "center-screen"  >
  <div   class = "card" style="text-align: center; position: absolute; left: 50%; margin-left: -250px; top: 20%">
    <h1 style= "text-align: center; margin-top: 10px;">
        Login
      </h1>
    <br>
    <br>
    <h3 style="color: red;"> <?php
    if (isset($_SESSION["login_error"])) {
        echo $_SESSION["login_error"] . ", please try again.";
    } 

    ?></h3>
    <br>


    <form method="post" action="../routes/process_login.php" name="myForm" onsubmit="redirectAfterLogin();">
          <br>
          <input class= "inputField" style="text-indent: 10px" placeholder="Username" type="text" id="username" name="username" required>
          <br>
          <br>
          <br>
          <input class= "inputField" style="text-indent: 10px" placeholder="Password" type="password" id="pwd" name="password" required>
          <br>
          <br>
          <br>
          <br>

      <div style="text-align: center">
          <input type="submit" class="inputField" value="Login" id = "submitButton">
          <br>
          <br>
          New here? 
          <a href="register.php">Create an account!</a>
      </div>
    </form>
  </div>
</div>

      <script>
        // SHA-256 hashing function
        function sha256(plain) {
            const encoder = new TextEncoder();
            const data = encoder.encode(plain);
            return window.crypto.subtle.digest('SHA-256', data).then(buffer => {
                let hashArray = Array.from(new Uint8Array(buffer));
                let hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
                return hashHex;
            });
        }

        
        function redirectAfterLogin() {
            const username = document.getElementById("username").value; // Get the entered username
            const password = document.getElementById("pwd").value; // Get the entered password

            // Hash the password using SHA-256
            sha256(password).then(hashedPassword => {
                // Set the hashed password back into the password field
                document.getElementById("pwd").value = hashedPassword;

                // Now, you can submit the form with the hashed password
                document.forms[0].submit();
            });
        }
      </script>
    </body>
</html>