<?php
session_start();
require "../../credentials.php";

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);

function test_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$itemid = null;
if (isset($_POST["itemid"])) {
    $_SESSION["item_selected"] = test_data($_POST["itemid"]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} 
if (isset($_SESSION["item_selected"])) {
    $itemid = $_SESSION["item_selected"];
} else {
    header("Location: ../" . $_SESSION["return_to"]);
    exit();
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	
	<head>
        <link rel="shortcut icon" href="icons/grocery.ico"/>
        <meta charset="utf-8">
        <title>Online Food Store</title>
		<meta name="viewport">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class="header">
            <a href="home.php" class="logo">
				<img src="../icons/food.png">
			</a>

			<div class="search-container">
				<h1 style="color:#88d498;"> Management Item Preview </h1>
			</div>

			<?php
					if (isset($_SESSION["username"])) {
						echo(
						"<a style = 'float: right; padding-top: 10px; padding-right: 20px;' class='cart' href='../routes/logout.php'>" .
							"Logout" .
						"</a>"
						);
					}
				?>
            	<a style = "float: right; padding-top: 10px; padding-right:25px;"  class="cart" href="../routes/account_link.php"><?php
					if (isset($_SESSION["username"])) {
						echo "<div class='account_text'><span><u>" . $_SESSION["username"] . "</u></span></div>";
					} else {
						echo "Login / Register";
					}
				?></a>
                <?php
					if (isset($_SESSION["is_employee"]) && $_SESSION["is_employee"]) {
						echo(
						"<a style = 'float: right; padding-top: 10px; padding-right: 20px;' class='cart' href='../templates/managerpage.php'>" .
							"Managment" .
						"</a>"
						);
					}
				?>
        </div>

		<div style="position: absolute; left: 0px; height: 200%; width: 2%; top 88px; background-color: var(--light-primary); z-index: 80"></div>
		<div style="position: absolute; right: 0px; height: 200%; width: 2%; top 88px; background-color: var(--light-primary); z-index: 80"></div>

		<div style="margin-left: 2%; margin-right: 2%; margin-top: 100px;">
				
                    
        
        <div class="searchResult" style="padding-top: 3%; width: 80%; height: 80%; background-color: white; position: absolute; top: 88px; margin-left: 10%; min-width:1000px">
			<h2>
                <?php

        // create connection 
        $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

        // check connection 
        
        $itemidq = "SELECT * FROM items WHERE item_id=$itemid";
        //$searchq = "SELECT * FROM items WHERE MATCH(item_keywords) AGAINST('$search' IN BOOLEAN MODE)";
        $itemidS = mysqli_query($conn,$itemidq);

        

        if (!$conn ) { 
            die ("Connection failed: " . mysqli_connect_error());
        } 
        else {
            if ($itemidS) {
                
                /* fetch associative array */
                $row = $itemidS->fetch_assoc();

                $item_id = $row["item_id"];
                $field2name = $row["item_name"];
                $i_description = $row["item_description"];
                $i_weight = $row["item_weight"];
                $i_price = $row["item_price"];
                $i_inv = $row["inv_count"];
                $i_keywords = $row["item_keywords"];
                $i_timesBought = $row["times_bought"];
                $i_img_link = $row["image_address"];
                if ($row["image_address"] == NULL) {
                    $i_img = '../icons/null_image.webp';
                } else {
                    $i_img = $row["image_address"];
                }


                echo "<img style= 'position: absolute; left: 20px; height:500px; width: 500px; background-color: white; border: solid black 1px;'src=\"$i_img\">";

                echo "

                    <div style='position: absolute; left: 550px; background-color: white; height:300px; width: 40%; padding-top: 5px;'>
                    <form action='../routes/update_item.php' method='post' >
                    <h4>Name</h4>
                    <input type = 'text' name = 'newName' value = '$field2name' style = 'width: 100%; boxing-size: border-box; font-size: 26px; padding: 10px; margin-bottom: 10px required'>
                    <br>
                    <h4>Description</h4>
                    <textarea  name = 'newDescription' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>$i_description</textarea>

                    <h4>Search Keywords</h4>

                    <textarea name = 'newKeywords' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>$i_keywords</textarea>

                    <h4>Image Address</h4>
                    <h6>Insert a public address to an image hosted on the web. Leave blank for no image.</h6>

                    <textarea name = 'newImage' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>$i_img_link</textarea>

                    <h4>Price</h4>
                    <input type = 'number' name = 'userPrice' value = $i_price min = '0' step = '0.01' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>
                    <h4>Weight Lbs</h4>
                    <input type = 'number' name = 'userWeight' value = $i_weight min = '0' step = '0.01' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>
                    <br>
                    <input type='hidden' name='item_id' value=$item_id>
                    <input type='hidden' name='times_bought' value=$i_timesBought>

                    <h4>Stock Quantity</h4>
                    <h6>Set to 0 to hide item from search.</h6>
                    <input type = 'number' name = 'userNumber' value = $i_inv min = '0' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>

                    <input type='submit' name='update' value='Update' style='border: 1px solid white; font-size: 30px; color: white; background-color: var(--dark);height: 60px; width: 340px; border-radius:3px ;position: relative;'> 
                        
                    
                                
                    </form>
                    <form action='../routes/remove_item.php' method='post' >
                    <input type='hidden' name='item_id' value=$item_id>
                    <input type = 'submit' name='remove' value='Delete' style='border: 1px solid white; font-size: 30px; color: white; background-color: var(--dark); height: 60px; width: 340px; border-radius: 3px; position: relative;''>

                    </form>

                    </div>

                ";
                
                echo "";
                
                
            
                /* free result set */
                $itemidS->free();
            }
            exit();
        
            } 

    ?>
    
    </h2>
		</div> 
    
		
    </body>
</html>


