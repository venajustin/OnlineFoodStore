
<?php

    session_start();
    unset($_SESSION["address_error"]);

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (!isset($_SESSION["username"])) {
        header('Location: '.$uri.'/OnlineFoodStore/templates/login.php');
        exit;
    }
	
    if ((isset($_POST["address1"])) && isset($_POST["city"]) && isset($_POST["zipCode"]) && isset($_POST["state"]) && isset($_POST["country"])) {
        if($_POST["address1"] && $_POST["city"] && $_POST["zipCode"]&& $_POST["state"]&& $_POST["country"]) {
            
            require "../../credentials.php";

            // create connection 
            $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
            // check connection 
            if (!$conn) { 
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $address1 = test_input($_POST["address1"]);
            $city = test_input($_POST["city"]);
            $zip = test_input($_POST["zipCode"]);
            $state = test_input($_POST["state"]);
            $country = test_input($_POST["country"]);

            if (isset($_POST["address2"]) && $_POST["address2"]) {
                $address2 = test_input($_POST["address2"]);
            } else {
                $address2 = "";
            }
			
			
                     

            // try-catch to avoid fatal error message of duplicate inptus
            try {
                // register user
                $uid = $_SESSION["user_id"];
                $sql = "REPLACE INTO address_information VALUES ('$uid', '$address1', '$address2', '$city', '$state', '$zip', '$country' )";
                $results = mysqli_query($conn, $sql);


                // check result and connection
                if ($results) { 
                   
                    header("Location: ../templates/checkout/review.php");
                    exit();
                } else {
                    $_SESSION["address_error"] = " id not found ";
                    echo mysqli_error($conn);
                }
            } catch(Exception $error) {
                $_SESSION["address_error"] = "add error";
                echo 'Error: ' . $error->getMessage();
            }
            
            // close connection 
            mysqli_close($conn);

        } else {
            echo "Username or Password is empty.";
            $_SESSION["address_error"] = "must fill all required feilds";
        }
    } else {
        $_SESSION["address_error"] = "must fill all required feilds";
    }
	
    header("Location: ../templates/checkout/address_details.php");
    exit();
?>
