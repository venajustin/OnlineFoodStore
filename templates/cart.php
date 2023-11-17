<?php
session_start();
require "../../credentials.php";

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);

$_SESSION["return_to"] = "templates/cart.php";

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<?php
		if (!isset($_SESSION["username"])) {
			header('Location: '.$uri.'/OnlineFoodStore/templates/login.php');
		}
	?>
    <head>
		<link rel="shortcut icon" href="icons/grocery.ico"/>
        <meta charset="utf-8">
        <title>Online Food Store</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
	<style>
	</style>
    <body>

		<!--Page Header-->

        <div class="header">
            <a href="home.php" class="logo">
				<img src="../icons/food.png">
			</a>
			<div class="search-container">
				<form action="../templates/search.php" method="post">
					<input type="text" placeholder="Search.." name="search" >
					

					<button type="submit">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" viewBox="0 0 32 40" version="1.1" xml:space="preserve" style="" x="0px" y="0px" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2"><g transform="matrix(1,0,0,1,-192,-96)"><path fill="currentColor" stroke="currentColor" d="M202.766,116.29L194.313,124.273C193.912,124.652 193.894,125.285 194.273,125.687C194.652,126.088 195.285,126.106 195.687,125.727L204.224,117.664C206.093,119.127 208.445,120 211,120C217.071,120 222,115.071 222,109C222,102.929 217.071,98 211,98C204.929,98 200,102.929 200,109C200,111.796 201.045,114.349 202.766,116.29ZM211,100C215.967,100 220,104.033 220,109C220,113.967 215.967,118 211,118C206.033,118 202,113.967 202,109C202,104.033 206.033,100 211,100Z"/></g></svg>
					</button>
					
				</form>
			</div>
			
                <a style = "float: right"  class="cart" href="cart.php">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none" x="0px" y="0px"><path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18.2001 21.9854C18.2001 20.3285 19.5432 18.9854 21.2001 18.9854H28.0777C29.4325 18.9854 30.6192 19.8934 30.9733 21.2011L33.6329 31.0212H78.7999C79.7022 31.0212 80.5565 31.4273 81.1262 32.1269C81.6959 32.8266 81.9205 33.7455 81.7377 34.629L76.5795 59.5604C76.3193 60.8178 75.2879 61.7702 74.0138 61.9295L39.6259 66.228C38.1424 66.4134 36.7489 65.4784 36.3581 64.0354L25.7821 24.9854H21.2001C19.5432 24.9854 18.2001 23.6422 18.2001 21.9854ZM35.2579 37.0212L41.468 59.951L71.139 56.2421L75.1157 37.0212H35.2579ZM45.5 73.0073C44.6716 73.0073 44 73.6789 44 74.5073C44 75.3357 44.6716 76.0073 45.5 76.0073C46.3284 76.0073 47 75.3357 47 74.5073C47 73.6789 46.3284 73.0073 45.5 73.0073ZM38 74.5073C38 70.3652 41.3579 67.0073 45.5 67.0073C49.6421 67.0073 53 70.3652 53 74.5073C53 78.6495 49.6421 82.0073 45.5 82.0073C41.3579 82.0073 38 78.6495 38 74.5073ZM69.4999 73.0073C68.6715 73.0073 67.9999 73.6789 67.9999 74.5073C67.9999 75.3357 68.6715 76.0073 69.4999 76.0073C70.3284 76.0073 70.9999 75.3357 70.9999 74.5073C70.9999 73.6789 70.3284 73.0073 69.4999 73.0073ZM62 74.5073C62 70.3652 65.3578 67.0073 69.4999 67.0073C73.6421 67.0073 76.9999 70.3652 76.9999 74.5073C76.9999 78.6495 73.6421 82.0073 69.4999 82.0073C65.3578 82.0073 62 78.6495 62 74.5073Z" fill="black"/></svg>
				</a>

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
						echo "<div class='account_text'><span>Welcome <u>" . $_SESSION["username"] . "</u>!</span></div>";
					} else {
						echo "Login / Register";
					}
				?></a>
        </div>

		



		<!--List Containing Items from Shopping Cart-->				
		<div class="center-screen" style="padding-top: 7%;">
			<div class="card" style="width: max(800px); text-align: center;">
				<br>
				
				<h1 style="color: #46b35e;">Shopping Cart</h1>
				<br>

				<ul class="cart" style="background-color:skyblue" id="cart">
				<?php
				// create connection 
				$conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

				$sql6 = "SELECT value FROM global_variables WHERE name = 'sales_tax'";
				$salesTax_results = mysqli_query($conn, $sql6);

				$uid = $_SESSION["user_id"];  
				// check connection 
				$sql = "SELECT item_id, item_name, quantity, item_description, item_weight, item_price
						FROM items
						INNER JOIN shopping_cart ON items.item_id = shopping_cart.i_id
						AND shopping_cart.u_id = $uid";
				//$searchq = "SELECT * FROM items WHERE MATCH(item_keywords) AGAINST('$search' IN BOOLEAN MODE)";
				$itemS = mysqli_query($conn,$sql);

				$sub_total = 0;
				$total_weight = 0;
				$num_items = mysqli_num_rows($itemS);
				$total = 0;

				if (!$conn ) { 
					die ("Connection failed: " . mysqli_connect_error());
				} 
				else {
					if ($itemS) {

						if ($num_items == 0) {
							
							echo "
									
										
										<div style=' background-color: white; padding-top: 5px;'>
											<h3>Cart is Empty!</h3>
											<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
										</div>
									
								
							";
						} else {
							echo "

							<div style=' background-color: white; padding-top: 5px;'>
								<form action='../routes/cart_action.php' method='post' >
									
									<input style='color: red' type='submit' name='remove_all' value='Remove all from Cart'>
									
								</form>
							</div>

							";


						}
						/* fetch associative array */

						while ($row = $itemS->fetch_assoc()) {
							$i_id = $row["item_id"];
							$i_name = $row["item_name"];
							$i_description = $row["item_description"];
							$i_weight = $row["item_weight"];
							$i_price = $row["item_price"];
							$i_quantity = $row["quantity"];

							$sub_total += $i_price * $i_quantity;
							$total_weight += $i_weight * $i_quantity;

							echo "
									<div class = 'searchTile' style='background-color: white; padding-top: 5px;'>
									<form action='../templates/item.php' method='post'>
										<button style='background-color: white; border:none; width: 100%;text-align:left; padding-left: 40px; font-size:20px;' name='itemid' value =$i_id>
											<img style= 'position: absolute; height:150px; left: 120px ;width: 150px; background-color: white; border: solid black 1px;'src=\"./food/$i_id.png\">
											<div style='padding-left: 130px; padding-top: 5px;'>
												<h3>$i_name  x $i_quantity</h3>
											</div>
											<div style='padding-left: 130px; padding-top: 5px;'>$i_description</div>
											<div style='padding-left: 130px; padding-top: 5px;'>
												Weight: $i_weight		
											</div>
										</button>
									</form>
										<div class='edit-quantity-buttons'>
									
											<form action='../routes/cart_action.php' method='post' >
												<input type='hidden' name='item_to_edit' value=$i_id>
												<input type='submit' name='subtract' value='-'>
												<input style='width:50px;' type='text' name='quantity' value=1>
												<input type='submit' name='add' value='+'>
											</form>
										</div>
									</div>
							";
							echo "";
						}
					
						/* free result set */
						$itemS->free();
					} 
					
				}
				?>
			</ul>
			
			</div>


			<div class="card" style="margin-left: 40px; width: max(300px);">
					<br>
					<h1 style="color: #46b35e;">Cart Summary</h1>
					<br><br><br>
					
					<div style="background-color: none; white; height: fit-content; border-bottom: solid grey 1px; position: relative">
					
					<h3>Number of Items: </h3>
						<?php
							echo $num_items;
						?>
						<br>
						<h3>Total Weight: </h3>
						<?php
							echo $total_weight;
						?>
						<br>
					</div>
					<br>
					<div style="background-color: none; height; fit-content; border-bottom: solid grey 1px">
						<h3>Subtotal: </h3>
						<?php
							echo $sub_total;
						?>
						<br><br>
						<h3>Delivery Fee: </h3>
						<?php
							if ($total_weight < 20){
									echo "$0.00";
							} else {
								echo "$5.00";
								$total += 5;
							}
							
						?>
						<br><br>
						<h3>Sales Tax: </h3>
						<?php
							
							if (!$salesTax_results) {
								echo "No information set";
							} else {
								$tax = mysqli_fetch_assoc($salesTax_results);
								if (!$tax) {
									echo "No information set";
								} 
							}
							$stax = $sub_total * $tax["value"];
							echo "$" . number_format((float)$stax, 2, '.', '');
							$total += $stax;
									
									
						?>
						<br><br>
					</div>
					<br>
					<h3>Total: </h3>
					<?php
					    $total += $sub_total;
						echo "$" . number_format((float)$total, 2, '.', '');
					?>

					<div style='position: relative; border-top: 1px solid grey; padding-top: 2%;'>
						<a href='checkout/review.php'>
						<button style='border: 1px solid white; font-size: 30px; color: white; background-color: var(--dark);height: 60px; width: 200px; border-radius:3px ;position: relative; '>
							Checkout</button>
						</a>
					</div>
				</div>
		</div>
						
					
    </body>
	
</html>
