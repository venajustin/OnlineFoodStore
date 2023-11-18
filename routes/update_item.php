
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
        $item_id = $_POST["item_id"];
        $userNumber = $_POST["userNumber"];
        $newPrice = $_POST["userPrice"];
        $newWeight = $_POST["userWeight"];
        $newKeyWords = $_POST["newKeywords"];
        $newDescription = $_POST["newDescription"];
        $newName = $_POST["newName"];
    
        $sql = "UPDATE items SET item_weight = $newWeight, inv_count = $userNumber, item_name = '$newName',item_price = $newPrice WHERE item_id = $item_id";
        $results = mysqli_query($conn, $sql);
    
        if ($conn->query($sql) === TRUE) {
            echo "Stock updated successfully";
        } else {
            echo "Error updating stock: " . $conn->error;
        }
    }
    
    header("Location: ../templates/managerpage.php");
    exit();
?>
