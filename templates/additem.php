<?php
session_start();
require "../../credentials.php";

unset($_SESSION["signup_error"]);
unset($_SESSION["login_error"]);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	
	<head>
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
				<h1 style="color:#88d498;"> Management Item Preview: Add Item </h1>
			</div>


            

    
   
		</div> 
        <div style="position: absolute; left: 0px; height: 200%; width: 2%; top 88px; background-color: var(--light-primary); z-index: 80"></div>
		<div style="position: absolute; right: 0px; height: 200%; width: 2%; top 88px; background-color: var(--light-primary); z-index: 80"></div>

		<div style="margin-left: 2%; margin-right: 2%; margin-top: 100px;">


        <br><br><br><br><br><br>
        <div class="searchResult" style="padding-top: 3%; width: 80%; height: 80%; background-color: white; position: absolute; top: 88px; margin-left: 10%; min-width:1000px">
             <img style= 'position: absolute; left: 20px; height:500px; width: 500px; background-color: white; border: solid black 1px;'src="../icons/null_image.webp">
             <h2>
             <div style='position: absolute; left: 550px; background-color: white; height:300px; width: 40%; padding-top: 5px;'>
                <form action='../routes/register_item.php' method='post' >
                <h4>Name</h4>
                <input type = 'text' name = 'newName' style = 'width: 100%; boxing-size: border-box; font-size: 26px; padding: 10px; margin-bottom: 10px required'>
                <br>
                <h4>Description</h4>
                <textarea  name = 'newDescription' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'></textarea>

                <h4>Search Keywords</h4>

                <textarea name = 'newKeywords' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'></textarea>

                <h4>Image Address</h4>
                <h6>Insert a public address to an image hosted on the web.</h6>

                <textarea name = 'newImage' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'></textarea>

                <h4>Price</h4>
                <input type = 'number' name = 'userPrice' min = '0.01' step = '0.01' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>
                <h4>Weight Lbs</h4>
                <input type = 'number' name = 'userWeight' min = '0.01' step = '0.01' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>
                <br>

                <h4>Stock Quantity</h4>
                <h6>Set to 0 to hide item from search.</h6>
                <input type = 'number' name = 'userNumber' min = '1' style = 'width: 100%; boxing-size: border-box; font-size: 18px; padding: 10px; margin-bottom: 10px'>

                <input type='submit' name='update' value='Add Item' style='border: 1px solid white; font-size: 30px; color: white; background-color: var(--dark);height: 60px; width: 340px; border-radius:3px ;position: relative;'> 
                          
                </form>
                </div>

             </h2>
             
    
    </div>
        
    
		
    </body>
</html>


