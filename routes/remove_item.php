
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
        
    
        $sql = "DELETE FROM items WHERE item_id = $item_id";
        try {
            $results = mysqli_query($conn, $sql);
        } catch (Exception $e) {
            $_SESSION["manager_status"] = "Stock removed, Item has been purchased and cannot be permanently removed.";
            $sql = "UPDATE items
                    SET inv_count = 0
                    WHERE item_id = $item_id";
            mysqli_query($conn, $sql);
        }
        
    }
    
    header("Location: ../templates/managerpage.php");
    exit();
?>
