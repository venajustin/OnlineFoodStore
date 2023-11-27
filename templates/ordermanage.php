<?php
session_start();
require "../../credentials.php";

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);

if (!isset($_SESSION["username"]) or !$_SESSION["is_employee"]) {
	header('Location: '.$uri.'/OnlineFoodStore/routes/account_link.php');
	exit;
  }


function test_data($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$oid = null;
if (isset($_POST["order_id"])) {
    $_SESSION["order_selected"] = test_data($_POST["order_id"]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} 
if (isset($_SESSION["order_selected"])) {
    $oid = $_SESSION["order_selected"];
} else {
    header("Location: ../" . $_SESSION["return_to"]);
    exit();
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
if (!isset($_SESSION["username"])) {
	header('Location: ' . $uri . '/OnlineFoodStore/templates/login.php');
}
?>

<head>
	<link rel="shortcut icon" href="icons/grocery.ico" />
	<meta charset="utf-8">
	<title>Online Food Store</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
</head>
<style>
</style>

<body style="padding-bottom: 50px">

	<!--Page Header-->

	<div class="header">
		<a href="home.php" class="logo">
			<img src="../icons/food.png">
		</a>
		<div class="search-container">
			<form action="../templates/search.php" method="post">
				<input type="text" placeholder="Search.." name="search">


				<button type="submit">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
						xmlns:serif="http://www.serif.com/" viewBox="0 0 32 40" version="1.1" xml:space="preserve"
						style="" x="0px" y="0px" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round"
						stroke-miterlimit="2">
						<g transform="matrix(1,0,0,1,-192,-96)">
							<path fill="currentColor" stroke="currentColor"
								d="M202.766,116.29L194.313,124.273C193.912,124.652 193.894,125.285 194.273,125.687C194.652,126.088 195.285,126.106 195.687,125.727L204.224,117.664C206.093,119.127 208.445,120 211,120C217.071,120 222,115.071 222,109C222,102.929 217.071,98 211,98C204.929,98 200,102.929 200,109C200,111.796 201.045,114.349 202.766,116.29ZM211,100C215.967,100 220,104.033 220,109C220,113.967 215.967,118 211,118C206.033,118 202,113.967 202,109C202,104.033 206.033,100 211,100Z" />
						</g>
					</svg>
				</button>

			</form>
		</div>

		<a style="float: right; margin-right:1%; padding-top: 4px; padding-bottom: 4px;" class="cart" href="cart.php">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none" x="0px" y="0px">
				<path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18.2001 21.9854C18.2001 20.3285 19.5432 18.9854 21.2001 18.9854H28.0777C29.4325 18.9854 30.6192 19.8934 30.9733 21.2011L33.6329 31.0212H78.7999C79.7022 31.0212 80.5565 31.4273 81.1262 32.1269C81.6959 32.8266 81.9205 33.7455 81.7377 34.629L76.5795 59.5604C76.3193 60.8178 75.2879 61.7702 74.0138 61.9295L39.6259 66.228C38.1424 66.4134 36.7489 65.4784 36.3581 64.0354L25.7821 24.9854H21.2001C19.5432 24.9854 18.2001 23.6422 18.2001 21.9854ZM35.2579 37.0212L41.468 59.951L71.139 56.2421L75.1157 37.0212H35.2579ZM45.5 73.0073C44.6716 73.0073 44 73.6789 44 74.5073C44 75.3357 44.6716 76.0073 45.5 76.0073C46.3284 76.0073 47 75.3357 47 74.5073C47 73.6789 46.3284 73.0073 45.5 73.0073ZM38 74.5073C38 70.3652 41.3579 67.0073 45.5 67.0073C49.6421 67.0073 53 70.3652 53 74.5073C53 78.6495 49.6421 82.0073 45.5 82.0073C41.3579 82.0073 38 78.6495 38 74.5073ZM69.4999 73.0073C68.6715 73.0073 67.9999 73.6789 67.9999 74.5073C67.9999 75.3357 68.6715 76.0073 69.4999 76.0073C70.3284 76.0073 70.9999 75.3357 70.9999 74.5073C70.9999 73.6789 70.3284 73.0073 69.4999 73.0073ZM62 74.5073C62 70.3652 65.3578 67.0073 69.4999 67.0073C73.6421 67.0073 76.9999 70.3652 76.9999 74.5073C76.9999 78.6495 73.6421 82.0073 69.4999 82.0073C65.3578 82.0073 62 78.6495 62 74.5073Z"fill="black" /></svg>
		</a>

		<?php
		if (isset($_SESSION["username"])) {
			echo (
				"<a style = 'float: right; padding-top: 10px; padding-right: 20px;' class='cart' href='../routes/logout.php'>" .
				"Logout" .
				"</a>"
			);
		}
		?>
		<a style="float: right; padding-top: 10px; padding-right:25px;" class="cart" href="../routes/account_link.php">
			<?php
			if (isset($_SESSION["username"])) {
				echo "<div class='account_text'><span><u>" . $_SESSION["username"] . "</u></span></div>";
			} else {
				echo "Login / Register";
			}
			?>
		</a>
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





	<!--List Containing Items from Shopping Cart-->
	<div
		style=" left: 3%; top: 120px; position: absolute; margin-bottom: 3%; padding-bottom: 30px; margin-bottom: 3%; background-color: white;">
		<div class="card"
			style="width: max(1000px); text-align: center; background-color: maroon; box-shadow: 0px 0px 7px grey; z-index: 80;">
			<br>

			<h1 style="color: #46b35e;">Order Details</h1>
			<br>

			<ul class="cart" style="background-color:skyblue" id="cart">
				<?php
				// create connection 
				$conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

				$sql = "SELECT u_id, total_weight, total_price, completed
						FROM order_history
						WHERE order_id = $oid";
				$order_details = mysqli_query($conn, $sql);

				$orderRow = $order_details->fetch_assoc();

				


				if (!$_SESSION["is_employee"]) {
					header("Location: ../" . "templates/home.php");
					exit();
				}

				$users_id = $orderRow["u_id"];

				$total_weight = $orderRow["total_weight"];
				$total_price = $orderRow["total_price"];
				$order_status = ($orderRow["completed"] == 1) ? "Shipped!" : "pending...";

				$order_details->free();

				// check connection 
				$sql = "SELECT item_id, item_name, quantity, item_description, item_weight, image_address
						FROM items
						INNER JOIN order_information 
						ON order_information.o_id = $oid
						AND items.item_id = order_information.i_id";
				//$searchq = "SELECT * FROM items WHERE MATCH(item_keywords) AGAINST('$search' IN BOOLEAN MODE)";
				$itemS = mysqli_query($conn, $sql);

				$num_items = mysqli_num_rows($itemS);
				$total_item_quantity = 0;

				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				} else {
				


					if ($itemS) {


						
						/* fetch associative array */

						while ($row = $itemS->fetch_assoc()) {
						
							$i_id = $row["item_id"];
							$i_name = $row["item_name"];
							$i_description = $row["item_description"];
							$i_weight = $row["item_weight"];
							$i_quantity = $row["quantity"];

							if ($row["image_address"] == NULL) {
								$i_img = '../icons/null_image.webp';
							} else {
								$i_img = $row["image_address"];
						  	}

							$total_item_quantity += $i_quantity;

							echo "
									<div class = 'searchTile' style='background-color: white; padding-top: 5px;'>
										<form action='../templates/item.php' method='post'>
											<button style='background-color: white; border:none; width: 100%;text-align:left; padding-left: 40px; font-size:20px;' name='itemid' value =$i_id>
												<img style= 'position: absolute; height:150px; left: 2%; width: 150px; background-color: white; border: solid grey 1px;'src=\"$i_img\">
												<div style='padding-left: 130px; padding-top: 5px;'>
													<h3>$i_name  x $i_quantity </h3>";

							echo "
												</div>
												<div style='padding-left: 130px; padding-top: 5px;'>$i_description</div>
												<div style='padding-left: 130px; padding-top: 5px;'>
													Weight: $i_weight		
												</div>
											</button>
										</form>
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


		<div class="card"
			style="margin-left: 40px; width: max(300px); position: fixed; right: 3%; top: 120px; text-align: center; box-shadow: 0px 0px 7px grey">
			<br>
			<h1 style="color: #46b35e;">Order Summary</h1>
			<br><br><br>

			<div
				style="background-color: none; white; height: fit-content; border-bottom: solid grey 1px; position: relative">
				
				<?php
				echo "<h4>Order Number: $oid</h4>";
				?>
				<?php
				echo "<h4>User ID: $users_id</h4>";
				?>
				<h4>Order Status: </h4>
				<?php
				echo $order_status;
				?>
				<br>
				<br>
			</div>
			<br>
			<div style="background-color: none; height; fit-content; border-bottom: solid grey 1px">
				<h3>Number of Items: </h3>
				<?php
				echo number_format($total_item_quantity, 0);
				?>
				<br>
				<h3>Total Weight: </h3>
				<?php
				echo number_format($total_weight, 2) . " lbs";
				?>

				<br><br>
			</div>
			<br>
			<h3>Total Cost: </h3>
			<?php
			
			echo "$" . number_format((float) $total_price, 2);

			$sql1 = "SELECT address_line1, address_line2, city, state_province, zip_code, country 
					FROM address_information 
					WHERE user_id = $users_id";
			$address_results = mysqli_query($conn, $sql1);
			

			if ( mysqli_num_rows($address_results) == 0) {
				echo "
				<div style='position: relative; border-top: 1px solid grey; padding-top: 2%;'>
				<h3>No address details provided</h3>
				</div>";
			} else {
			$row = $address_results->fetch_assoc();
			
			$uaddr_line1 = $row['address_line1'] ? $row['address_line1'] : "empty";
			$uaddr_line2 = $row['address_line2'] ? $row['address_line2'] : "empty";
			$uaddr_city = $row['city'] ? $row['city'] : "empty";
			$uaddr_sprovince = $row['state_province'] ? $row['state_province'] : "empty";
			$uaddr_zip = $row['zip_code'] ? $row['zip_code'] : "empty" ;
			$uaddr_country = $row['country'] ? $row['country'] : "empty";


			echo "
			<div style='position: relative; border-top: 1px solid grey; padding-top: 2%;'>
				
				<h3>Delivery Address: </h3>
				$uaddr_line1 <br> ";
			if ($uaddr_line2 != "empty") {
				echo $uaddr_line2 . "<br>";
			}
			echo "
				$uaddr_city,&nbsp$uaddr_sprovince&nbsp&nbsp$uaddr_zip &nbsp&nbsp$uaddr_country 
				
				<br>
			</div>
			";
			}

			echo "
			<div style='position: relative; border-top: 1px solid grey; padding-top: 2%;'>
				<form action='../routes/complete_order.php' method='post' >
					
					<button
						style='border: 1px solid white; font-size: 30px; color: white; background-color: var(--dark);height: 75px; width: 280px; border-radius:3px ;position: relative; '
						name='order_id' value=$oid>
						Complete Order</button>
				</form>
			</div>
			";
			
			?>
		</div>
		

	</div>


</body>

</html>
