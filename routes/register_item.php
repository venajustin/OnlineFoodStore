
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
            $_SESSION["manager_status"] = "You must provide a name, no item added.";
            header("Location: ../templates/managerpage.php");
            exit();
        }

        if ($_POST["userNumber"] == "") {
            $userNumber = 0;
        } else {
            $userNumber = test_input($_POST["userNumber"]);
        }
        if ($_POST["userPrice"] == "") {
            $newPrice = 0;
        } else {
            $newPrice = test_input($_POST["userPrice"]);
        }
        if ($_POST["userWeight"] == "") {
            $newWeight = 0;
        } else {
            $newWeight = test_input($_POST["userWeight"]);
        }
        if ($_POST["newKeywords"] == "") {
            $newKeyWords = "";
        } else {
            $newKeyWords = test_input($_POST["newKeywords"]);
        }
        if ($_POST["newDescription"] == "") {
            $newDescription = "";
        } else {
            $newDescription = test_input($_POST["newDescription"]);
        }
        if ($_POST["newName"] == "") {
            $newName = "";
        } else {
            $newName = test_input($_POST["newName"]);
        }
       
        
        
    
        $sql = "INSERT INTO items (item_name, item_description, item_weight, item_price, times_bought, item_keywords, inv_count) 
                VALUES ('$newName', '$newDescription', $newWeight, $newPrice, 0, '$newKeyWords', $userNumber)";
        $results = mysqli_query($conn, $sql);

        if ($conn->query($sql) === TRUE) {
            echo "Stock updated successfully";
            $_SESSION["manager_status"] = "$newName added to database";
        } else {
            echo "Error updating stock: " . $conn->error;
            $_SESSION["manager_status"] =  "Error updating stock: " . $conn->error;
        }
    
    }
    
    header("Location: ../templates/managerpage.php");
    exit();
?>
