<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

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
<div class = "center-screen">
  <div class = "card" style="text-align: center;">
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


    <form method="post" action="../routes/process_login.php" name="myForm">
          <input class= "inputField" style="text-indent: 10px" placeholder="Username" type="text" name="username" required>
          <br>
          <br>
          <input class= "inputField" style="text-indent: 10px" placeholder="Password" type="password" id="pwd" name="password" required>
          <br>
          <br>
          <div style="text-align: left; text-indent: 30px;">
            <a href="changepassword.php">Forgot Password?</a>
          </div>
          
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


    </body>
</html>