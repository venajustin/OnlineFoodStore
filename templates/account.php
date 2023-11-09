<?php
session_start();
unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);

if (!isset($_SESSION["username"])) {
    header('Location: '.$uri.'/OnlineFoodStore/templates/login.php');
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

	
	<head>
    <style>
        /* Style for the main container */
        .container {
            width: 90%; /* Change width to 90% */
            height: 30vh; /* Height set to 30% of the viewport height */
            margin: 0 auto; /* Center the container */
        }

        /* Style for the navigation bar */
        .navbar {
            background-color: #1c3144; /* Dark blue background */
            width: 90%; /* Change width to 90% */
            overflow: hidden;
            margin: 0 auto; /* Center the navbar */
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* Change hover background color to a lighter complementary shade */
        .navbar a:hover {
            background-color: #254261; /* A lighter complementary shade */
            color: white;
            text-decoration: none;
        }

        /* Style for the main content area */
        .content {
            background-color: white;
            padding: 20px;
        }

        /* Hide content initially */
        .content > div {
            display: none;
            height: 80vh;
        }

        /* Show content based on button click */
        .content div.active {
            display: block;
        }
    </style>
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
				<form action="../templates/search.php" method="post">
					<input type="text" placeholder="Search.." name="search">
					

					<button type="submit">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" viewBox="0 0 32 40" version="1.1" xml:space="preserve" style="" x="0px" y="0px" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2"><g transform="matrix(1,0,0,1,-192,-96)"><path fill="currentColor" stroke="currentColor" d="M202.766,116.29L194.313,124.273C193.912,124.652 193.894,125.285 194.273,125.687C194.652,126.088 195.285,126.106 195.687,125.727L204.224,117.664C206.093,119.127 208.445,120 211,120C217.071,120 222,115.071 222,109C222,102.929 217.071,98 211,98C204.929,98 200,102.929 200,109C200,111.796 201.045,114.349 202.766,116.29ZM211,100C215.967,100 220,104.033 220,109C220,113.967 215.967,118 211,118C206.033,118 202,113.967 202,109C202,104.033 206.033,100 211,100Z"/></g></svg>
					</button>
					
				</form>
			</div>
			
                <a style = "float: right; margin-right: 1%; padding-top: 4px; padding-bottom: 4px;" class="cart" href="cart.php">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none" x="0px" y="0px"><path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18.2001 21.9854C18.2001 20.3285 19.5432 18.9854 21.2001 18.9854H28.0777C29.4325 18.9854 30.6192 19.8934 30.9733 21.2011L33.6329 31.0212H78.7999C79.7022 31.0212 80.5565 31.4273 81.1262 32.1269C81.6959 32.8266 81.9205 33.7455 81.7377 34.629L76.5795 59.5604C76.3193 60.8178 75.2879 61.7702 74.0138 61.9295L39.6259 66.228C38.1424 66.4134 36.7489 65.4784 36.3581 64.0354L25.7821 24.9854H21.2001C19.5432 24.9854 18.2001 23.6422 18.2001 21.9854ZM35.2579 37.0212L41.468 59.951L71.139 56.2421L75.1157 37.0212H35.2579ZM45.5 73.0073C44.6716 73.0073 44 73.6789 44 74.5073C44 75.3357 44.6716 76.0073 45.5 76.0073C46.3284 76.0073 47 75.3357 47 74.5073C47 73.6789 46.3284 73.0073 45.5 73.0073ZM38 74.5073C38 70.3652 41.3579 67.0073 45.5 67.0073C49.6421 67.0073 53 70.3652 53 74.5073C53 78.6495 49.6421 82.0073 45.5 82.0073C41.3579 82.0073 38 78.6495 38 74.5073ZM69.4999 73.0073C68.6715 73.0073 67.9999 73.6789 67.9999 74.5073C67.9999 75.3357 68.6715 76.0073 69.4999 76.0073C70.3284 76.0073 70.9999 75.3357 70.9999 74.5073C70.9999 73.6789 70.3284 73.0073 69.4999 73.0073ZM62 74.5073C62 70.3652 65.3578 67.0073 69.4999 67.0073C73.6421 67.0073 76.9999 70.3652 76.9999 74.5073C76.9999 78.6495 73.6421 82.0073 69.4999 82.0073C65.3578 82.0073 62 78.6495 62 74.5073Z" fill="black"/></svg>
				</a>

            	<a style = "float: right;"  class="cart" href="../routes/account_link.php"><?php
					if (isset($_SESSION["username"])) {
						echo $_SESSION["username"] . "<br>User Settings";
					} else {
						echo "Login /<br>Register";
					}
				?></a>
        </div>
             
       <div class="container" style ="margin-top: 10%;">
       <div class="navbar">
        <a href="#" onclick="showTab('tab1')">Account Settings</a>
        <a href="#" onclick="showTab('tab2')">Address Details</a>
        <a href="#" onclick="showTab('tab3')">Payment Methods</a>
        
        <?php
                if ($_SESSION["is_employee"]) {
                    echo('<a href="managerpage.php">Manager Page</a>');
                }
                ?>
                
        <a href="../routes/logout.php" onclick="showTab('tab4')">Logout</a>
    </div>
    <div class="container">
        <div class="content">
            <div class="active" id="tab1"> Account Info
                

            </div>
            <div id="tab2">Shipping Address
                <br>
                <div style="flex-grow: 5"> 
                    <?php
                        if (!$address_results) {
                            echo "No information set";
                        } else {
                            $address = mysqli_fetch_assoc($address_results);
                            if (!$address) {
                                echo "No information set";
                            } else {
                                echo "Address Line 1: " . $address["address_line1"] . "<br>";
                                if ($address["address_line2"] != "") {
                                    echo "Address Line 2: " . $address["address_line2"] . "<br>";
                                }
                                
                                echo "City: " . $address["city"] . "<br>";
                                echo "State: " . $address["state_province"] . "<br>";
                                echo "ZIP: " . $address["zip_code"] . "<br>";
                                echo "Country: " . $address["country"] . "<br>";
                            }
                            
                        }
                        
                    
                    ?>
                </div>

            </div>
            <div id="tab3">Payment Info</div>
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
    </body>
</html>




