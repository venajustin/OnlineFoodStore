<!-- My (An) Code from HW2, just a tmp placement for now since we're using AWS idk if this still applies-->

<!-- This code checks the database based on the entry of user/pass submission for login -->

<?php

    $logged_in = false; 

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if ($_POST["username"] && $_POST["password"]) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // create connection 
            $conn = mysqli_connect("localhost", "root", "", "users");

            // check connection 
            if (!$conn) { 
                die ("Connection failed: " . mysqli_connect_error());
            }

            // select user (must create user database beforehand)
            $sql = "SELECT password FROM users WHERE username = '$username'";

            $results = mysqli_query($conn, $sql);

            if ($results) {

                $row = mysqli_fetch_assoc($results);
                if ($row["password"] === $password) { 
                    $logged_in = true;
                    $sql = "SELECT * FROM users";
                    $results = mysqli_query($conn, $sql);
                    echo "SUCCESS: You have logged in!";
                } else {
                    echo "FAILED: Password is incorrect!";
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
