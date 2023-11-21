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

    function db_error() {
       
        $_SESSION["cart_message"] = "Could not place order, database error.";
        header('Location: '.$uri.'/OnlineFoodStore/templates/cart.php');
        exit();
        
    }


    $uid = $_SESSION["user_id"];
    require "../../credentials.php";

    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
    if (!$conn) { 
        die("Connection failed: " . mysqli_connect_error());
        db_error();
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
                $tax["value"] = 0.08;
                echo "No information set";
            }
        }
        $stax = $sub_total * $tax["value"];


        
        $cartSize = $itemS->num_rows;
        if ($cartSize == 0) {
            $_SESSION["cart_message"] = "Your Shopping Cart is empty, nothing to order!";
            header('Location: '.$uri.'/OnlineFoodStore/templates/cart.php');
            exit();
        } 

       
        
        $sql = "INSERT INTO order_history
            VALUES ($uid, null, default, default, default)";
        $newOrderResult = mysqli_query($conn, $sql);
        if (!$newOrderResult) {
            db_error();
        }
        $oid = $conn->insert_id;
        
        $itemsOrdered = 0;
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
                $itemsOrdered++;
                $sql =  "INSERT INTO order_information
                        VALUES ($oid, $i_id, $i_quantity)";
                if (mysqli_query($conn, $sql)) {
                    $sql = "DELETE FROM shopping_cart
                            WHERE u_id = $uid AND i_id = $i_id";
                    mysqli_query($conn, $sql);
                    $sql = "UPDATE items
                            SET inv_count = $i_stock - $i_quantity
                            WHERE item_id = $i_id";
                    mysqli_query($conn, $sql);
                }
            }
        }
        $total_price = $sub_total;
        $total_price += ($total_weight > 20) ? 5 : 0;
        $total_price *= (1 + $tax["value"]);

        if ($itemsOrdered != 0) {
            $sql = "UPDATE order_history
                    SET total_weight = $total_weight, total_price = $total_price
                    WHERE order_id = $oid";
            mysqli_query($conn, $sql);
        } else {
            $sql = "DELETE FROM order_history
                    WHERE order_id = $oid";
            mysqli_query($conn, $sql);
           
            $_SESSION["cart_message"] = "None of your items could be ordered, please order amounts we have in stock.";
            header('Location: '.$uri.'/OnlineFoodStore/templates/cart.php');
            exit();
        }


        if ($itemsOrdered < $cartSize) {
            $_SESSION["cart_message"] = "Order placed! <br> However, some items could not be ordered, please order an amount we have in stock.";
            header('Location: '.$uri.'/OnlineFoodStore/templates/cart.php');
            exit();
        }

        header('Location: '.$uri.'/OnlineFoodStore/templates/account.php');
        exit();


    }
?>