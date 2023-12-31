<?php
session_start();
unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);
unset($_SESSION["return_to"]);



require "../../credentials.php";
$dberror = false;
$conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
if (!$conn) {
	$dberror = true;
}



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
	<link rel="shortcut icon" href="icons/grocery.ico" />
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

		<a style="float: right; margin-right: 1%; padding-top: 4px; padding-bottom: 4px;" class="cart" href="cart.php">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none" x="0px" y="0px">
				<path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
					d="M18.2001 21.9854C18.2001 20.3285 19.5432 18.9854 21.2001 18.9854H28.0777C29.4325 18.9854 30.6192 19.8934 30.9733 21.2011L33.6329 31.0212H78.7999C79.7022 31.0212 80.5565 31.4273 81.1262 32.1269C81.6959 32.8266 81.9205 33.7455 81.7377 34.629L76.5795 59.5604C76.3193 60.8178 75.2879 61.7702 74.0138 61.9295L39.6259 66.228C38.1424 66.4134 36.7489 65.4784 36.3581 64.0354L25.7821 24.9854H21.2001C19.5432 24.9854 18.2001 23.6422 18.2001 21.9854ZM35.2579 37.0212L41.468 59.951L71.139 56.2421L75.1157 37.0212H35.2579ZM45.5 73.0073C44.6716 73.0073 44 73.6789 44 74.5073C44 75.3357 44.6716 76.0073 45.5 76.0073C46.3284 76.0073 47 75.3357 47 74.5073C47 73.6789 46.3284 73.0073 45.5 73.0073ZM38 74.5073C38 70.3652 41.3579 67.0073 45.5 67.0073C49.6421 67.0073 53 70.3652 53 74.5073C53 78.6495 49.6421 82.0073 45.5 82.0073C41.3579 82.0073 38 78.6495 38 74.5073ZM69.4999 73.0073C68.6715 73.0073 67.9999 73.6789 67.9999 74.5073C67.9999 75.3357 68.6715 76.0073 69.4999 76.0073C70.3284 76.0073 70.9999 75.3357 70.9999 74.5073C70.9999 73.6789 70.3284 73.0073 69.4999 73.0073ZM62 74.5073C62 70.3652 65.3578 67.0073 69.4999 67.0073C73.6421 67.0073 76.9999 70.3652 76.9999 74.5073C76.9999 78.6495 73.6421 82.0073 69.4999 82.0073C65.3578 82.0073 62 78.6495 62 74.5073Z"
					fill="black" />
			</svg>
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
			echo (
				"<a style = 'float: right; padding-top: 10px; padding-right: 20px;' class='cart' href='../templates/managerpage.php'>" .
				"Managment" .
				"</a>"
			);
		}
		?>


	</div>



	<div class="main">
		<div id="welcome-box">
			<h1>Welcome to Online Food Store!<h1>
					<h2>Browse our selection of featured and popular items below or search our site to discover all the
						wonderful food items we have in stock!</h2>
		</div>

		<?php
		if ($dberror) {
			echo "<h1>DATABASE ERROR: Features of this site are unavailable at the moment due to an error connecting to the database</h1>";
		}
		?>

		<div id="item-container-label-box">
			<h1>Featured Items</h1>
			<div id="item-container">
				<?php

				$php = "SELECT item_id, item_name, image_address, item_price
						FROM items
						WHERE is_featured = 1";
				$results = mysqli_query($conn, $php);

				while ($row = mysqli_fetch_assoc($results)) {
					$img = $row["image_address"];
					$name = $row["item_name"];
					$price = $row["item_price"];
					$id = $row["item_id"];
					echo "<div class='item'> <a href='./item.php?itemid=$id'>";

					echo "<img src='$img'>";
					echo "<h2>$name $$price</h2>";


					echo '</a></div>';
				}
				?>
			</div>

		</div>

				

			<div id="item-container-label-box" style="height: auto;">
				<h1>Categories</h1>
				<div id="featured-container">
					<form action='../templates/search.php' method='post'>
						<button type='submit' class='itemTile' name='search' value='Produce' style='box-shadow: 0px 0px 7px grey'>
							<h2>Produce</h2>
							<img src='food/1.png' style='width: 100%; max-width: 125px'>
						</button>
					</form>
					
					<form action='../templates/search.php' method='post'>
						<button type='submit' class='itemTile' name='search' value='Dairy' style='box-shadow: 0px 0px 7px grey'>
							<h2>Dairy</h2>
							<img src='food/milk.png' style='width: 100%; max-width: 125px;'>										
						</button>
					</form>
					<form action='../templates/search.php' method='post'>
						<button type='submit' class='itemTile' name='search' value='Grain' style='box-shadow: 0px 0px 7px grey'>
							<h2>Grains and Bread</h2>
							<img src='food/rice.png' style='width: 100%; max-width: 125px;'>										
						</button>
					</form>
					<form action='../templates/search.php' method='post'>
						<button type='submit' class='itemTile' name='search' value='Protein' style='box-shadow: 0px 0px 7px grey'>
							<h2>Protein</h2>
							<img src='food/chicken.png' style='width: 100%; max-width: 125px;'>										
						</button>
					</form>
				</div>
			
			</div>


		<div id="item-container-label-box">
			<h1>Most Popular</h1>
			<div id="item-container">
				<?php

				$php = "SELECT item_id, item_name, image_address, item_price, times_bought
						FROM items
						WHERE inv_count <> 0
						ORDER BY times_bought DESC
						LIMIT 6";
				$results = mysqli_query($conn, $php);

				while ($row = mysqli_fetch_assoc($results)) {
					$img = $row["image_address"];
					$name = $row["item_name"];
					$price = $row["item_price"];
					$id = $row["item_id"];
					$num_times_bought = $row["times_bought"];
					echo "<div class='item extra-tall'> <a href='./item.php?itemid=$id'>";

					echo "<img src='$img'>";
					echo "<h2>$name $$price</h2>";
					echo "<h4> Purchased $num_times_bought times!</h4>";

					echo '</a></div>';
				}
				?>
			</div>




		</div>
		<div id="item-container-label-box" style="height:auto; max-height:none; padding-bottom:15px;">
			<h1>About us</h1>
			<div style="display:flex; justify-content:space-between; ">
				<div style="padding: 15px; width:50%;">
					<p style="font-family: 'Gill Sans', sans-serif; font-size: 110%;">
						Welcome to OnlineFoodStore! We are passionate food enthusiasts dedicated to bringing you the
						finest culinary experiences right to your doorstep. Our journey began with a simple goal: to
						make exceptional food accessible to everyone, no matter where they are. With a curated selection
						of delectable delights, sourced from local artisans and global epicurean destinations, we aim to
						delight your taste buds and inspire your kitchen adventures. At OnlineFoodStore, we prioritize
						quality, freshness, and variety, offering a diverse range of products that cater to all tastes,
						dietary preferences, and cooking styles. Whether you're a seasoned chef or an aspiring home
						cook, we are here to be your trusted partner on your gastronomic journey. Join us in savoring
						the flavors of the world, one delectable bite at a time.
					</p>
				</div>
				<img src="./pictures/about_us_pic.jpeg" style="width:40%; object-fit:cover; margin-right:15px; border-radius:15px;">
			</div>


		</div>


	


		<div
			style="width: 100%; height: 20%; background-color: none; position: absolute; top: 3800px; margin-left: 45%; border: none">
			<img src="../icons/city.png"
				style="width: 15%; margin-left: 40%; margin-right: auto; display: block; scale: 500%; position: absolute; bottom: 0px">
		</div>

		<div
			style="width: 100%; height: 20%; background-color: none; position: absolute; top: 3900px; left: 50%; transform: translateX(-50%); border: none;">
			<a href="home.php" class="logo">
				<img src="../icons/food-dark.png" style="width: 5%; display: block; margin: 0 auto;">
			</a>
		</div>

		<div
			style="width: 100%; height: 20%; background-color: none; position: absolute; top: 3800px; margin-right: 50%; border: none">
			<img src="../icons/city.png"
				style="transform: scaleX(-1); width: 15%; margin-right: 40%; margin-left: auto; display: block; scale: 500%; position: absolute; bottom: 0px">
		</div>
	</div>

</body>
</html>