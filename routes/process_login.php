
<?php

    $logged_in = false; 

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if ($_POST["username"] && $_POST["password"]) {
            $username = $_POST["username"];
            $password = $_POST["password"];

			$hostname = 'onlinefoodstore.c2zn58sjaobh.us-west-1.rds.amazonaws.com';
			$dbuser = 'server';
			$dbpass = 'Kiifne9283';
			$dbname = 'user';
			

            // create connection 
            $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

            // check connection 
            if (!$conn) { 
                die ("Connection failed: " . mysqli_connect_error());
            }

            // select user (must create user database beforehand)
            $sql = "SELECT password FROM accounts WHERE username = '$username'";

            $results = mysqli_query($conn, $sql);

            if ($results) {

                $row = mysqli_fetch_assoc($results);
				if ($row) {
					
					if ($row["password"] === $password) { 
						$logged_in = true;
						$sql = "SELECT * FROM accounts";
						$results = mysqli_query($conn, $sql);
						echo "SUCCESS: You have logged in!";
					} else {
						echo "FAILED: Password is incorrect!";
					}
				} else {
					echo "username could not be found, please <a href='../templates/Register.html'>REGISTER</a>!";
				}

            } else {
				
                echo mysqli_error($conn);
            }

            mysqli_close($conn);

        } else {
            echo "Username or Password is empty.";
        }
    }

?>
