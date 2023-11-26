
<?php

    session_start();
    unset($_SESSION["address_error"]);

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    if(isset($_SESSION["is_employee"]) != 1){
        header('Location: '.$uri. '/OnlineFoodStore/templates/home.php');
        exit;
    }

    require "../../credentials.php";

    // create connection 
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
    // check connection 
    if (!$conn) { 
        die("Connection failed: " . mysqli_connect_error());
        
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "test";
        $item_id = test_input($_POST["item_id"]);
        
    
        $sql = "UPDATE items
                    SET inv_count = 0
                    WHERE item_id = $item_id";
        if(mysqli_query($conn, $sql)) {
            $_SESSION["manager_status"] = "All inventory removed. Item hidden from search page.";
        } else {
            $_SESSION["manager_status"] = "Error updating inventory";
        }

        
    }
    
    header("Location: ../templates/managerpage.php");
    exit();
?>
