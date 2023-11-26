
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
        if ($_POST["newImage"] == "") {
            $newimg = NULL;
        } else {
            $newimg = $_POST["newImage"];
        }
       
        
        $sql = "SELECT item_name, item_id
                FROM items
                WHERE item_name = '$newName'";
        $results = mysqli_query($conn, $sql);
        if(mysqli_num_rows($results) > 0) {
            $row = $results->fetch_assoc();
            $i_id = $row["item_id"];
            $_SESSION["manager_status"] = "<form action='../templates/itempreview.php' method='post'>$newName already exists, please <button name='itemid' style='all:unset; color:blue; text-decoration: underline;' value =$i_id>edit this item</button> instead.<form> ";
            header("Location: ../templates/managerpage.php");
            exit();
        }
        
    
        $sql = "INSERT INTO items (item_name, item_description, item_weight, item_price, times_bought, item_keywords, inv_count, image_address) 
                VALUES ('$newName', '$newDescription', $newWeight, $newPrice, 0, '$newKeyWords', $userNumber, '$newimg')";
        

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
