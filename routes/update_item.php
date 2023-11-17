
<?php

    session_start();
    unset($_SESSION["address_error"]);

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    require "../../credentials.php";

    // create connection 
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
    // check connection 
    if (!$conn) { 
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $item_id = $_POST["iid"];
        $userNumber = $_POST["userNumber"];
        $nameChange = $_POST["newName"];
        $newPrice = $_POST["userPrice"];
    
        $sql = "UPDATE items SET inv_count = $userNumber, item_name = '$nameChange', item_price = $newPrice WHERE item_id = $item_id";
    
        if ($conn->query($sql) === TRUE) {
            echo "Stock updated successfully";
        } else {
            echo "Error updating stock: " . $conn->error;
        }
    }
    
    header("Location: ../templates/managerpage.php");
    exit();
?>
