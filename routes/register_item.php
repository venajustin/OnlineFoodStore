
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
        $userNumber = $_POST["userNumber"];
        $newPrice = $_POST["userPrice"];
        $newWeight = $_POST["userWeight"];
        $newKeyWords = $_POST["newKeywords"];
        $newDescription = $_POST["newDescription"];
        $newName = $_POST["newName"];
    
        $sql = "INSERT INTO items (item_name, item_description, item_weight, item_price, times_bought, item_keywords, inv_count) VALUES ('$newName', '$newDescription', $newWeight, $newPrice, 0, '$newKeyWords', $userNumber)";
        $results = mysqli_query($conn, $sql);
    
    }
    
    header("Location: ../templates/managerpage.php");
    exit();
?>
