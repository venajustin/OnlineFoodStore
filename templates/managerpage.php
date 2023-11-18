<?php
session_start();

if (!isset($_SESSION["username"]) or !$_SESSION["is_employee"]) {
	header('Location: '.$uri.'/OnlineFoodStore/routes/account_link.php');
	exit;
  }

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);
unset($_SESSION["return_to"]);

require "../../credentials.php";
$conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

$search = $_POST["search"];

if (!$conn ) { 
	die ("Connection failed: " . mysqli_connect_error());
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
            width: 90%;
            height: 30%;
            margin: 0 auto;
        }

        /* Style for the navigation bar */
        .navbar {
            background-color: #1c3144;
            width: 90%;
            overflow: hidden;
            margin: 0 auto;
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
            height: 80vh;
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

		<div style="position: absolute; left: 0px; height: 200%; width: 2%; top 88px; background-color: var(--light-primary); z-index: 80"></div>
		<div style="position: absolute; right: 0px; height: 200%; width: 2%; top 88px; background-color: var(--light-primary); z-index: 80"></div>

		<div style="margin-left: 2%; margin-right: 2%; margin-top: 100px;">

			<br><br>

			
			<div class="container" style ="margin-top: 5%;">
				<div class="navbar">
				<button onclick="showTab('tab1')">Inventory</button>
				<button onclick="showTab('tab2')">Add New Item</button>
				<button onclick = "window.location.href='../routes/account_link.php'">User Settings</button>
				</div>
				<div class="container">
					<div class="content">
						<div class="active" id="tab1">
						<?php 
							$allItems = "SELECT * FROM items";
							$itemS = mysqli_query($conn,$allItems);
							echo "";
							
							// Select all data from the table

							if ($itemS->num_rows > 0) {
								// Output data of each row
								while($row = $itemS->fetch_assoc()) {
									$i_id = $row["item_id"];
									echo '<div style="border-bottom: solid gray 1px; padding-top: 7px; padding-bottom: 5px; margin: 10px; display: flex; justify-content: space-between; align-items: center;">';
									echo "ID: " . $row["item_id"] . " - Name: " . $row["item_name"] . " - Price: " . $row["item_price"] . " - Stock: " . $row["inv_count"];
									echo "<form action='../templates/itempreview.php' method='post'>";
									echo "<button style='width: 50px; height: 20px;border: solid 1px black; background-color: var(--dark); color: white;'name='itemid' value =$i_id>Edit</button>";
										
									echo"</form>";
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
		


		<div style="width: 100%; height: 20%; background-color: none; position: absolute; top: 1400px; margin-left: 45%; border: none">
			<img src="../icons/city.png" style="width: 15%; margin-left: 40%; margin-right: auto; display: block; scale: 500%; position: absolute; bottom: 0px">
		</div>

		<div style="width: 100%; height: 20%; background-color: none; position: absolute; top: 1500px; left: 50%; transform: translateX(-50%); border: none;">
			<a href="home.php" class="logo">
				<img src="../icons/food-dark.png" style="width: 5%; display: block; margin: 0 auto;">
			</a>
		</div>

		<div style="width: 100%; height: 20%; background-color: none; position: absolute; top: 1400px; margin-right: 50%; border: none">
			<img src="../icons/city.png" style="transform: scaleX(-1); width: 15%; margin-right: 40%; margin-left: auto; display: block; scale: 500%; position: absolute; bottom: 0px">
		</div>

    </body>

</html>
