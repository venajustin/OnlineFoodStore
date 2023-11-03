
<?php

    session_start();
    unset($_SESSION["payment_error"]);

    if (!isset($_SESSION["username"])) {
        header('Location: '.$uri.'/OnlineFoodStore/templates/login.php');
        exit;
    }
	
    if ((isset($_POST["cardType"])) && isset($_POST["cardNumber"]) && isset($_POST["cardExpiry"]) && isset($_POST["cardCVV"] && isset($_POST["billingAddress"])) ) {
        if($_POST["cardType"] && $_POST["cardNumber"] && $_POST["cardExpiry"]&& $_POST["cardCVV"] && $_POST["billingAddress"]) {
            $cardType = $_POST["cardType"];
            $cardNumber = $_POST["cardNumber"];
            $cardExpiry = $_POST["cardExpiry"];
            $cardCVV = $_POST["cardCVV"];
            $billingAddress = $_POST["billingAddress"];
			
			require "../../credentials.php";

            // create connection 
            $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
            // check connection 
            if (!$conn) { 
                die("Connection failed: " . mysqli_connect_error());
            }
                     

            // try-catch to avoid fatal error message of duplicate inptus
            try {
                // register user
                $uid = $_SESSION["user_id"];
                $sql = "REPLACE INTO payment_information VALUES ('$uid', '$cardType', '$cardNumber', '$cardExpiry', '$cardCVV', '$billingAddress')";
                $results = mysqli_query($conn, $sql);

                // check result and connection
                if ($results) { 
                   
                    header("Location: ../templates/checkout/review.php");
                    exit();
                } else {
                    $_SESSION["payment_error"] = " id not found ";
                    echo mysqli_error($conn);
                }
            } catch(Exception $error) {
                $_SESSION["payment_error"] = "sql backend error";
                echo 'Error: ' . $error->getMessage();
            }
            
            // close connection 
            mysqli_close($conn);

        } else {
            echo "Username or Password is empty.";
            $_SESSION["payment_error"] = "must fill all required feilds";
        }
    } else {
        $_SESSION["payment_error"] = "must fill all required feilds";
    }
	
    header("Location: ../templates/checkout/card_details.php");
    exit();
?>
