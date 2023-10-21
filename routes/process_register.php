
<?php


	
    if ((isset($_POST["username"])) && isset($_POST["password"])) {
        if($_POST["username"] && $_POST["password"] && $_POST["password2"] && $_POST["password"] === $_POST["password2"]) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            
            $isManager = 0;
			
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
            
            if (isset($_POST["Masterkey"]) && strlen($_POST["Masterkey"]) > 1) {
                $key = $_POST["Masterkey"];
                $sql = "SELECT value FROM global_variables WHERE name = 'masterkey'";

                $results = mysqli_query($conn, $sql);

                if ($results) {

                    $row = mysqli_fetch_assoc($results);
                    if ($row) {
                        
                        if ($row["value"] === $key) { 
                            $isManager = 1;
                        } else {
                            echo "FAILED: Manager key is incorrect!";
                            
                            header("Location: ../templates/login.html");
                            exit();
                        
                        }
                    } else {
                        echo "error";
                    }
    
                } else {
                    
                    echo mysqli_error($conn);
                }
            }

            // try-catch to avoid fatal error message of duplicate inptus
            try {
                // register user
                $sql = "INSERT INTO users VALUES (null, '$username', '$password', '$isManager')";
                
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
        header("Location: ../templates/login.html");
        exit();
    }
	
?>
