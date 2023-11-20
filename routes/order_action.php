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


        $sql = "SELECT item_id, item_name, quantity, inv_count, item_price, item_weight
                FROM items
                INNER JOIN shopping_cart ON items.item_id = shopping_cart.i_id
                AND shopping_cart.u_id = $uid";

        $itemS = mysqli_query($conn, $sql);

        $sub_total = 0;
        $total_weight = 0;
        
        $sql6 = "SELECT value FROM global_variables WHERE name = 'sales_tax'";
		$salesTax_results = mysqli_query($conn, $sql6);
        if (!$salesTax_results) {
            echo "No information set";
            $tax["value"] = 0.08;
        } else {
            $tax = mysqli_fetch_assoc($salesTax_results);
            if (!$tax) {
                echo "No information set";
            }
        }
        $stax = $sub_total * $tax["value"];


        $sql = "INSERT INTO order_history
                VALUES ($uid, null, default, default)";
        $newOrderResult = msqli_query($conn, $sql);
        if (!$newOrderResult) {
            echo "could not create order";
        }


        while ($row = mysqli_fetch_assoc($itemS)) {

            $i_id = $row["item_id"];
            $i_name = $row["item_name"];
            $i_weight = $row["item_weight"];
            $i_price = $row["item_price"];
            $i_quantity = $row["quantity"];
            $i_stock = $row["inv_count"];

            $sub_total += $i_price * $i_quantity;
            $total_weight += $i_weight * (float) $i_quantity;
            
            if ($i_stock >= $i_quantity) {
                $sql =  "";
            }

        }





    }
?>