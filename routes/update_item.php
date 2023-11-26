
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
        if ($_POST["newName"] == "") {
            $_SESSION["manager_status"] = "You must provide a name, database unmodified.";
            header("Location: ../templates/managerpage.php");
            exit();
        }

        echo "test";
        $item_id = test_input($_POST["item_id"]);
        $userNumber = test_input($_POST["userNumber"]);
        $newPrice = test_input($_POST["userPrice"]);
        $newWeight = test_input($_POST["userWeight"]);
        $newKeyWords = test_input($_POST["newKeywords"]);
        $newDescription = test_input($_POST["newDescription"]);
        $newName = test_input($_POST["newName"]);
    
        $sql = "UPDATE items SET item_description = '$newDescription', item_keywords = '$newKeyWords', item_weight = $newWeight, inv_count = $userNumber, item_name = '$newName',item_price = $newPrice WHERE item_id = $item_id";
        $results = mysqli_query($conn, $sql);
    
        if ($conn->query($sql) === TRUE) {
            echo "Stock updated successfully";
            $_SESSION["manager_status"] = "$newName updated in database.";
        } else {
            echo "Error updating stock: " . $conn->error;
            $_SESSION["manager_status"] =  "Error updating stock: " . $conn->error;
        }
    }
    
    header("Location: ../templates/managerpage.php");
    exit();
?>
