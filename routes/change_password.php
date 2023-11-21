
<?php

    session_start();
    unset($_SESSION["signup_error"]);
    unset($_SESSION["login_error"]);


    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
	
   
        
    require "../../credentials.php";

    // create connection 
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

    $username = test_input($_SESSION["username"]);
    $uid = $_SESSION["user_id"];
    $password = test_input($_POST["password"]);
    $newPass1 = test_input($_POST["newPassword"]);
    $newPass2 = test_input($_POST["newPassword2"]);

    if ($newPass1 != $newPass2) {
        $_SESSION["change_pwd_err"] = "New password and confirmation must match";
        header("Location: ../templates/account.php");
        exit();
    }

    

    // check connection 
    if (!$conn) { 
        die("Connection failed: " . mysqli_connect_error());
    }
    
    
    $sql = "SELECT password FROM users WHERE user_id = $uid";

    $results = mysqli_query($conn, $sql);

    if (!$results) {
        $_SESSION["change_pwd_err"] = "Database Error";
        header("Location: ../templates/account.php");
        exit();
    }

    $row = mysqli_fetch_assoc($results);
    $db_pass = $row["password"];
    if ($password != $db_pass) {
        $_SESSION["change_pwd_err"] = "Incorrect Password";
        header("Location: ../templates/account.php");
        exit();
    }

    $sql = "UPDATE users
            SET password = '$newPass1'
            WHERE user_id = $uid";
    if (!mysqli_query($conn, $sql)) {
        $_SESSION["change_pwd_err"] = "Database Error on password change";
        header("Location: ../templates/account.php");
        exit();
    }
    
    mysqli_close($conn);

       
    header("Location: ../templates/login.php");
    exit();
?>
