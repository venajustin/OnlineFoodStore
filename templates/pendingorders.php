<?php
session_start();

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

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);
unset($_SESSION["return_to"]);

require "../../credentials.php";
$conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

$search = test_data($_POST["search"]);

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
		
			<div style="margin: 4%; margin-top: 100px; margin-bottom: 3%; box-shadow: 0px 0px 7px grey;">
				<div class="navbar" style="z-index: 150; box-shadow: 0px 0px 7px grey;">
					
                    <button onclick = "window.location.href='../templates/managerpage.php'">Inventory</button>
					<button onclick = "window.location.href='../templates/additem.php'">Add New Item</button>
					<button>Pending Orders</button>
                    <?php //<button onclick = "window.location.href='../routes/account_link.php'">User Settings</button> 
                    ?>
				</div>

				<div class="container" style = "z-index: 20;">
                <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    // ORDER HISTORY LIST
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



                    // create connection 
                    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

                    $sql6 = "SELECT value FROM global_variables WHERE name = 'sales_tax'";
                    $salesTax_results = mysqli_query($conn, $sql6);

                    $uid = $_SESSION["user_id"];
                    $is_manager = $_SESSION["is_employee"];
                    

                    // check connection 
                    $sql = "SELECT order_id, total_weight, total_price, completed
                            FROM order_history
                            WHERE completed = 0
                            ORDER BY order_id DESC";
                    //$searchq = "SELECT * FROM items WHERE MATCH(item_keywords) AGAINST('$search' IN BOOLEAN MODE)";
                    $itemS = mysqli_query($conn, $sql);

                    $num_items = mysqli_num_rows($itemS);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    } else {
                       
                        if ($itemS) {

                            if ($num_items == 0) {

                                echo "
                                        
                                            
                                            <div style=' background-color: white; padding-top: 5px;'>
                                                <h3>All orders have been shipped and completed!</h3>
                                                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                            </div>
                                        
                                    
                                ";
                            } 
                            /* fetch associative array */

                            while ($row = $itemS->fetch_assoc()) {
                                $o_id = $row["order_id"];
                                $total_weight = $row["total_weight"];
                                $total_price = $row["total_price"];
                                $order_status = ($row["completed"] == 1) ? "Shipped!" : "pending...";

                               
                                echo "
                                        <div class = 'searchTile' style='background-color: white; padding-top: 5px;'>
                                            <form action='../templates/ordermanage.php' method='post'>
                                                <button style='background-color: white; border:none; width: 100%;text-align:left; padding-left: 40px; font-size:20px;' name='order_id' value =$o_id>
                                                    
                                                    <div style='padding-left: 20px; padding-top: 5px;'>
                                                        <h3>Order Number: $o_id<h3>";

                                echo "
                                                    </div>
                                                    <div style='padding-left: 20px; padding-top: 5px;'>Total Cost: $total_price</div>
                                                    <div style='padding-left: 20px; padding-top: 5px;'>
                                                        Weight: $total_weight		
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






                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    ?>



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
    </body>
</html>















