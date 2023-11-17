<?php
    session_start();

    if (!isset($_SESSION["username"])) {
        header('Location: '.$uri.'/OnlineFoodStore/templates/login.php');
        exit();
    }
    
    function test_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    $uid = $_SESSION["user_id"];
    require "../../credentials.php";

    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
    if (!$conn) { 
        die("Connection failed: " . mysqli_connect_error());
    } else {


    if (isset($_POST["item_to_edit"])) {
    
        $i_id = $_POST["item_to_edit"];
     

        $sql = "SELECT i_id, quantity FROM shopping_cart WHERE u_id = $uid AND i_id = $i_id";
        $results = mysqli_query($conn, $sql);
       
        $row = mysqli_fetch_assoc($results);

        if (isset($_POST["subtract"])) {
            $quantity = 1;
            if (isset($_POST["quantity"])) {
                $quantity = $_POST["quantity"];
            }
            if ($results->num_rows > 0) {
                $i_quantity = $row["quantity"];
                if ($i_quantity - $quantity < 1) {
                    $sql = "DELETE FROM shopping_cart 
                            WHERE u_id = $uid AND i_id = $i_id";
                    $results = mysqli_query($conn, $sql);
                } else {
                    $sql = "UPDATE shopping_cart
                            SET quantity=($i_quantity - $quantity)
                            WHERE u_id = $uid AND i_id = $i_id";
                    $results = mysqli_query($conn, $sql);
                }
            }


        } 
        if (isset($_POST["add"])) {
            $quantity = 1;
            if (isset($_POST["quantity"])) {
                $quantity = $_POST["quantity"];
            }
            if ($results->num_rows > 0) {
                $i_quantity = $row["quantity"];
                $sql = "UPDATE shopping_cart
                        SET quantity=($i_quantity + $quantity)
                        WHERE u_id = $uid AND i_id = $i_id";
                $results = mysqli_query($conn, $sql);
            } else {
                $sql = "INSERT INTO shopping_cart
                        VALUES ($uid, $i_id, $quantity)
                        ";
                $results = mysqli_query($conn, $sql);
            }
            
        }
    }

    if (isset($_POST["remove_all"])) {
        $sql = "DELETE FROM shopping_cart 
                WHERE u_id = $uid";
        $results = mysqli_query($conn, $sql);
    }

    }

    if (!isset($_SESSION["return_to"])) {
        header("Location: ../templates/home.php");
    } else {
        header("Location: ../" . $_SESSION["return_to"]);
        unset($_SESSION["return_to"]);
    }
    exit();

?>
