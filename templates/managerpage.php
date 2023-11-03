<?php
session_start();

if (!isset($_SESSION["username"]) or !$_SESSION["is_employee"]) {
	header('Location: '.$uri.'/OnlineFoodStore/routes/account_link.php');
	exit;
  }

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
	
	<head>
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
				<h1 style="color:#88d498;"> Management </h1>
			</div>

			<a class="cart" style = "float: right; margin-right: 1.5%; padding-top: 8px" href="../routes/account_link.php"> 
				<?php
					if (isset($_SESSION["username"])) {
						echo $_SESSION["username"];
					} else {
						echo "Login /<br>Register";
					}
				?>
			</a>
        </div>

		<div style="position: absolute; left: 0px; height: 200%; width: 2%; top 88px; background-color: var(--light-primary); z-index: 80"></div>
		<div style="position: absolute; right: 0px; height: 200%; width: 2%; top 88px; background-color: var(--light-primary); z-index: 80"></div>

		<div style="margin-left: 2%; margin-right: 2%; margin-top: 100px;">

			<!-- <div style="align-self: center;"> -->
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
			<!-- </div> -->

			<!-- fix this later ^^-->
			<!-- also need a logout button, maybe a drop down menu -->
			<br><br><br><br><br> 

			<h3> 
				<a href="../routes/account_link.php" style="color: black;" onmouseover="this.style.color='white'" onmouseout="this.style.color='black'">User settings</a>
			</h3>
			
			<br><br>

			<h3>Dashboard: </h3>
			<p>- Total sales and the number of completed orders</p>
			<p>- Include table or card in the center</p>

			<br><br>
			
			<h3>Order Management:</h3>
			<p>- List of completed orders</p>
			<p>- Use a table</p>
			
			<br><br>
			
			<h3>Inventory Management: Add or remove products</h3>
			<p>- List all products in the database here</p>
			<p>- Use a table</p>
		</div>
		
    </body>

</html>
