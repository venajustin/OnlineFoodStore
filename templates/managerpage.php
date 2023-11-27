<?php
session_start();

if (!isset($_SESSION["username"]) or !$_SESSION["is_employee"]) {
	header('Location: ' . $uri . '/OnlineFoodStore/routes/account_link.php');
	exit;
}

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);
unset($_SESSION["return_to"]);

function test_data($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}



require "../../credentials.php";
$conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

$search = test_data($_POST["search"]);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<title>Online Food Store</title>
	<meta name="viewport">
	<link rel="stylesheet" href="style.css">

	<style>
		/* Style for the main container */
		.container {
			width: 100%;
			height: auto;
			margin: 0 auto;
			overflow: scroll;
		}

		/* Style for the navigation bar */
		.navbar {
			background-color: #1c3144;
			width: 100%;
			overflow: hidden;
			margin: auto;
		}

		.navbar button {
			float: left;
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
			border: none;
			background: none;
			cursor: pointer;
		}

		/* Change hover background color to a lighter complementary shade */
		.navbar button:hover {
			background-color: #254261;
			color: white;
			text-decoration: none;
		}


		/* Style for the main content area */
		.content {
			background-color: white;
			padding: 20px;
		}

		/* Hide content initially */
		.content>div {
			display: none;
			height: 500px;
		}

		/* Show content based on button click */
		.content div.active {
			display: block;
		}
	</style>
</head>

<body>
	<div class="header">
		<a href="home.php" class="logo">
			<img src="../icons/food.png">
		</a>

		<div class="search-container">
			<h1 style="color:#88d498;"> Management </h1>
		</div>

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
	<div class="main" >
		<?php

		if (isset($_SESSION["manager_status"])) {
			echo "
				<div style=' margin: 4%; margin-top: 100px; box-shadow: 0px 0px 7px grey; padding-top: 0px;'>
					<h2 style='color: red;'>";

			echo $_SESSION["manager_status"];
			echo "	</h2>
				</div>
			";
			unset($_SESSION["manager_status"]);
		}

		?>

		<div style="margin: 4%; margin-top: 100px; margin-bottom: 3%; box-shadow: 0px 0px 7px grey;">
			<div class="navbar" style="z-index: 150; box-shadow: 0px 0px 7px grey;">
				<button onclick="showTab('tab1')">Inventory</button>
				<button onclick="window.location.href='../templates/additem.php'">Add New Item</button>
				<button onclick="window.location.href='../templates/pendingorders.php'">Pending Orders</button>
				<?php //<button onclick = "window.location.href='../routes/account_link.php'">User Settings</button>
				?>
			</div>

			<div class="container" style="z-index: 20;">
				<div class="content">
					<div class="active" id="tab1">
						<?php
						$allItems = "SELECT * FROM items";
						$itemS = mysqli_query($conn, $allItems);


						// Select all data from the table
						
						if ($itemS->num_rows > 0) {
							// Output data of each row
							while ($row = $itemS->fetch_assoc()) {
								$i_id = $row["item_id"];
								$color = 'white';
								if ($row["inv_count"] == '0') {
									$color = '#c2c2c2';
								}
								echo "<div style='background-color:$color; border-bottom: solid gray 1px; padding-top: 7px; padding-bottom: 5px; margin: 10px; display: flex; justify-content: space-between; align-items: center; z-index: 80'>";
								echo "ID: " . $row["item_id"] . " | Name: " . $row["item_name"] . " | Price: $" . $row["item_price"] . " | Stock: " . $row["inv_count"];

								if ($row["image_address"] == NULL) {
									echo " | NO IMAGE SET";
								}
								echo '<div style="display:flex; justify-content: space-between; align-items: center;">';


								echo "<form action='../routes/add_featured.php' method='post'>";
								$featured_button_color = 'var(--dark)';
								$featured_button_text = "Add to Featured";
								if ($row["is_featured"]) {
									$featured_button_color = 'var(--primary)';
									$featured_button_text = "Remove from Featured";
								}
								echo "<button style=' margin-right: 10px; width: 150px; height: 20px;border: solid 1px black; background-color: $featured_button_color; color: white;'name='itemid' value =$i_id>$featured_button_text</button>";
								echo "</form>";

								echo "<form action='../templates/itempreview.php' method='post'>";
								echo "<button style='width: 50px; height: 20px;border: solid 1px black; background-color: var(--dark); color: white;'name='itemid' value =$i_id>Edit</button>";
								echo "</form>";
								echo '</div>';
								echo '</div>';
							}
						} else {
							echo "0 results";
						}

						// Close the connection
						$conn->close();
						?>
					</div>
					<div id="tab2">
						<p>- List of completed orders</p>
						<p>- Use a table</p>
					</div>
					<div id="tab3">
						<p>- Edit Page</p>
						<p>- Use a table</p>
						<?php
						echo '<form action="../routes/update_item.php" method="post" style="display: flex; align-items: center;">';
						echo '<input type="hidden" name="item_id" value="' . $row["item_id"] . '">';
						echo 'Change name: ';
						echo '<input type="text" name="newName" maxlength="30" required style="margin-left: 10px;">';

						echo 'Change price: ';
						echo '<input type="number" name="userPrice" min = "0.01" step = "0.01" required style="margin-left: 10px;">';


						echo 'Change stock: ';
						echo '<input type="number" name="userNumber" min="1" required style="margin-left: 10px;">';
						echo '<input type="submit" value="Update" style="background-color: #1c3144; color: white; padding: 4px 8px; border: none; border-radius: 3px; cursor: pointer; margin-left: 5px;">';
						echo '</form>';

						?>
					</div>
				</div>

				<script>
					function showTab(tabId) {
						const contentDivs = document.querySelectorAll(".content > div");



						// Hide all content divs
						contentDivs.forEach(div => {
							div.classList.remove("active");
						});

						// Show the selected tab
						const selectedTab = document.getElementById(tabId);
						if (selectedTab) {
							selectedTab.classList.add("active");
						}


					}
				</script>
			</div>

		</div>
	</div>
</body>

</html>