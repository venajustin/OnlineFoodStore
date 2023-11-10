<?php
session_start();

if (!isset($_SESSION["username"]) or !$_SESSION["is_employee"]) {
	header('Location: '.$uri.'/OnlineFoodStore/routes/account_link.php');
	exit;
  }

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);

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
				<div class="search-container" style="padding-top: 10px; padding-bottom: 10px; padding-left: 1%; padding-right: 1%; background-color: var(--dark); border-radius: 50px; height: 60px; width: 82%; text-align: center;">
					<form action="../routes/action_page.php">
						<input type="text" placeholder="Search.." name="search" method="post" style="width: 88%; height: 40px;">

						<button type="submit" style="width: 40px; float: right; margin-right: 2%;">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" viewBox="0 0 32 40" version="1.1" xml:space="preserve" style="" x="0px" y="0px" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2">
								<g transform="matrix(1,0,0,1,-192,-96)">
									<path fill="currentColor" stroke="currentColor" d="M202.766,116.29L194.313,124.273C193.912,124.652 193.894,125.285 194.273,125.687C194.652,126.088 195.285,126.106 195.687,125.727L204.224,117.664C206.093,119.127 208.445,120 211,120C217.071,120 222,115.071 222,109C222,102.929 217.071,98 211,98C204.929,98 200,102.929 200,109C200,111.796 201.045,114.349 202.766,116.29ZM211,100C215.967,100 220,104.033 220,109C220,113.967 215.967,118 211,118C206.033,118 202,113.967 202,109C202,104.033 206.033,100 211,100Z"/>
								</g>
							</svg>
						</button>
					</form>
				</div>

			<br><br><br><br><br> 

			
			<div class="container" style ="margin-top: 5%;">
				<div class="navbar">
				<button onclick="showTab('tab1')">Dashboard</button>
				<button onclick="showTab('tab2')">Order Management</button>
				<button onclick="showTab('tab3')">Inventory Management</button>
				<button onclick = "window.location.href='../routes/account_link.php'">User Settings</button>
            	<button onclick="window.location.href='../routes/logout.php'">Logout</button>
				</div>
				<div class="container">
					<div class="content">
						<div class="active" id="tab1">
							<p>- Total sales and the number of completed orders</p>
							<p>- Include table or card in the center</p>
						</div>
						<div id="tab2">
							<p>- List of completed orders</p>
							<p>- Use a table</p>
						</div>
						<div id="tab3">
							<p>- List all products in the database here</p>
							<p>- Use a table</p>
							<?php 
							$allItems = "SELECT * FROM items";
							$itemS = mysqli_query($conn,$allItems);
							echo "<br>";
							
							// Select all data from the table

							if ($itemS->num_rows > 0) {
								// Output data of each row
								while($row = $itemS->fetch_assoc()) {
									echo "ID: " . $row["item_id"]. " - Name: " . $row["item_name"]. " - Price: " . $row["item_price"]. " - Stock: " . "<br>";
								}
							} else {
								echo "0 results";
							}

							// Close the connection
							$conn->close();
							?>
						</div>
						<div id="tab4"> </div>
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
