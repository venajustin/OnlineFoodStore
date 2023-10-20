
<?php


	
    if ((isset($_POST["username"])) && isset($_POST["password"])) {
        if($_POST["username"] && $_POST["password"]) {
            $username = $_POST["username"];
            $password = $_POST["password"];
			
			$hostname = 'onlinefoodstore.c2zn58sjaobh.us-west-1.rds.amazonaws.com';
			$dbuser = 'server';
			$dbpass = 'Kiifne9283';
			$dbname = 'onlinefoodstore';

            // create connection 
            $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
            // check connection 
            if (!$conn) { 
                die("Connection failed: " . mysqli_connect_error());
            }

            // try-catch to avoid fatal error message of duplicate inptus
            try {
                // register user
                $sql = "INSERT INTO users (user_id, username, password, is_employee) VALUES (null, '$username', '$password', 0)";
                
                $results = mysqli_query($conn, $sql);

                // check result and connection
                if ($results) { 
                    echo "The user has been added successfully.";
                } else {
                    echo mysqli_error($conn);
                }
            } catch(Exception $error) {
                echo 'Error: ' . $error->getMessage();
            }
            
            // close connection 
            mysqli_close($conn);

        } else {
            echo "Username or Password is empty.";
        }
    } else {
        echo "Form was not submitted.";
    }
	
?>
