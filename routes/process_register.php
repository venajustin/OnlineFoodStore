<!-- My (An) Code from HW2, just a tmp placement for now since we're using AWS idk if this still applies-->

<!-- This code registers the user/pass in a database -->

<?php
    if ((isset($_POST["username"])) && isset($_POST["password"])) {
        if($_POST["username"] && $_POST["password"]) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // create connection 
            $conn = mysqli_connect("localhost", "root", "", "users");

            // check connection 
            if (!$conn) { 
                die("Connection failed: " . mysqli_connect_error());
            }

            // try-catch to avoid fatal error message of duplicate inptus
            try {
                // register user (must create user database beforehand)
                $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
                
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
