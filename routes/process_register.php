
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
	
    if ((isset($_POST["username"])) && isset($_POST["password"])) {
        if($_POST["username"] && $_POST["password"] && $_POST["password2"] && $_POST["password"] === $_POST["password2"]) {
            
            
            $isManager = 0;
			
			require "../../credentials.php";

            // create connection 
            $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

            $username = test_input($_POST["username"]);
            $password = test_input($_POST["password"]);

            

            // check connection 
            if (!$conn) { 
                die("Connection failed: " . mysqli_connect_error());
            }
            
            if (isset($_POST["Masterkey"]) && strlen($_POST["Masterkey"]) > 1) {
                $key = test_input($_POST["Masterkey"]);
                $sql = "SELECT value FROM global_variables WHERE name = 'masterkey'";

                $results = mysqli_query($conn, $sql);

                if ($results) {

                    $row = mysqli_fetch_assoc($results);
                    if ($row) {
                        
                        if ($row["value"] === $key) { 
                            $isManager = 1;
                        } else {
                            echo "FAILED: Manager key is incorrect!";
                            
                            $_SESSION["signup_error"] = "Manager key is incorrect,";

                            if (!isset($_SESSION["return_to"])) {
                                header("Location: ../templates/home.php");
                            } else {
                                header("Location: ../" . $_SESSION["return_to"]);
                                unset($_SESSION["return_to"]);
                            }
                            exit();
                        
                        }
                    } else {
                        echo "error";
                    }
    
                } else {
                    
                    echo mysqli_error($conn);
                }
            }

            // try-catch to avoid fatal error message of duplicate inptus
            try {
                // register user
                $sql = "INSERT INTO users VALUES (null, '$username', '$password', '$isManager')";
                
                $results = mysqli_query($conn, $sql);

                // check result and connection
                if ($results) { 
                    echo "The user has been added successfully.";
                    header("Location: ../templates/login.php");
                    exit();
                } else {
                    $_SESSION["signup_error"] = "Username already taken, ";
                    echo mysqli_error($conn);
                }
            } catch(Exception $error) {
                $_SESSION["signup_error"] = "Username already taken, ";
                echo 'Error: ' . $error->getMessage();
            }
            
            // close connection 
            mysqli_close($conn);

        } else {
            echo "Username or Password is empty.";
            $_SESSION["signup_error"] = "Passwords must match,";
        }
    } else {
        $_SESSION["signup_error"] = "Username or Password feild empty,";
    }
	
    header("Location: ../templates/register.php");
    exit();
?>
