<!DOCTYPE html>
<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header('Location: '.$uri.'/OnlineFoodStore/templates/login.php');
        exit;
    }
        require "../../../credentials.php";
    
    
        $uid = $_SESSION["user_id"];
        $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
    
        if (!$conn) { 
            die ("Connection failed: " . mysqli_connect_error());
        }
    
        // address info
        $sql = "SELECT card_number, card_expiry, card_cvv, billing_address FROM payment_information WHERE user_id = '$uid'";
        $card_results = mysqli_query($conn, $sql);
    
        


?>
<html lang="en" dir="ltr">
   
	<style>
        /* IMPORTANT: This page is only accessible after login!
         WHEN BOOTING UP PAGE MAKE SURE USER IS LOGGED IN PHP CHECK REQUIRED
        */
        h3{
            float: left; 
            padding-left: 10px;
        }
    </style>
     <script>
     function validateForm() {
        const cardExpiry = document.forms["payment_info"]["cardExpiry"].value;
        const cardNumber = document.forms["payment_info"]["cardNumber"].value;
        const cardType = document.forms["payment_info"]["cardType"].value;
        const cardCVV = document.forms["payment_info"]["cardCVV"].value;

        const visaMastercardPattern = /^\d{16}$/; // 16 digits for Visa and Mastercard
        const americanExpressPattern = /^\d{15}$/; // 15 digits for American Express
        const expiryPattern = /^(0[1-9]|1[0-2])\/\d{2}$/; // MM/YY format
        const CVVPattern = /^\d{3}$/; // only wants 3 digits

        if ((cardType === "American Express" && !americanExpressPattern.test(cardNumber)) ||
            (cardType !== "American Express" && !visaMastercardPattern.test(cardNumber))) {
            alert("Error: Invalid Card Number!");
            return false; // Prevent form submission
        }

        if (!expiryPattern.test(cardExpiry)) {
            alert("Error: Invalid Expiration Date");
            return false; // Prevent form submission
        }

        if (!CVVPattern.test(cardCVV)) {
            alert("Error: Invalid CVV");
            return false;
        }

        return true;
    }
    </script>

	<head>
        <meta charset="utf-8">
        <title>Checkout: Enter Address</title> 
        <!--if account saves address skip this page-->
		<meta name="viewport">
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
    <div class="header">
            <a href="../home.php" class="logo">
				<img src="../icons/food.png">
			</a>
			<div class="search-container">
            <form action="../search.php" method="post">
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
                <?php
					if (isset($_SESSION["is_employee"]) && $_SESSION["is_employee"]) {
						echo(
						"<a style = 'float: right; padding-top: 10px; padding-right: 20px;' class='cart' href='../managerpage.php'>" .
							"Managment" .
						"</a>"
						);
					}
				?>
        </div>
        <div class="center-screen" style="float: center;  padding-top: 7%;">
            <div class="card" style="width: max(700px); text-align: center; box-shadow: 0px 0px 7px grey;">
                <br>
                <h1 style="color: #46b35e;">Card Details</h1>
                <br>
                <h3 style="color: red;"> <?php
                if (isset($_SESSION["payment_error"])) {
                    echo $_SESSION["payment_error"] . " please try again.";
                } 

                ?></h3>
                <br><br><br>
                <!--Change action to check card info.... or temp store card info for recipt in next html page-->
                <form method="post" action="../../routes/update_payment.php" name="payment_info" onsubmit="return validateForm()">
                
                    <div class="radio-buttons">
                        <label>
                            <input type="radio" name="cardType" value="Visa" required> <img src="../checkout/card_logos/visa-logo.jpeg" width = "100px", height = "56px">
                        </label>
                        <label>
                            <input type="radio" name="cardType" value="Mastercard" required> <img src="../checkout/card_logos/Mastercard-Logo.webp" width = "100px", height = "56px">
                        </label>
                        <label>
                            <input type="radio" name="cardType" value="American Express" required> <img src="../checkout/card_logos/American-Express.png" width = "100px", height = "56px">
                        </label>
                        <label>
                            <input type="radio" name="cardType" value="Discover" required> <img src="../checkout/card_logos/Discover-Logo.png" width = "100px", height = "56px">
                        </label>
                    </div>


                    <br><br>
                    <input class="inputField" style="text-indent: 10px" placeholder="Card Number" type="text" name="cardNumber" required>
                    <br><br>
                    <input class="inputField" style="text-indent: 10px" placeholder="Card Expiry Date (MM/YY)" type="text" name="cardExpiry" required>
                    <br><br>
                    <input class="inputField" style="text-indent: 10px" placeholder="CVV" type="text" name="cardCVV" required>
                    <br><br>
                    <input class="inputField" style="text-indent: 10px" placeholder="Billing Address" type="text" name="billingAddress" required>
                    <br><br>
                    <input type="submit" class="inputField" value="Continue" id = "submitButton">

                </form>
               
               

            </div>
            
        </div>
        
    </body>
</html>