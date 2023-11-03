
<?php
    session_start();

    
    function test_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    unset($_SESSION["signup_error"]);
    unset($_SESSION["login_error"]);


    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if ($_POST["username"] && $_POST["password"]) {
           

			$hostname = 'onlinefoodstore.c2zn58sjaobh.us-west-1.rds.amazonaws.com';
			$dbuser = 'server';
			$dbpass = 'Kiifne9283';
			$dbname = 'onlinefoodstore';
			

            // create connection 
            $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
            $username = test_data($_POST["username"]);
            $password = test_data($_POST["password"]);

            


            // check connection 
            if (!$conn) { 
                die ("Connection failed: " . mysqli_connect_error());
            } else {
                echo "connection success";
            }

            // select user (must create user database beforehand)
            $sql = "SELECT password, user_id, is_employee FROM users WHERE username = '$username'";

            $results = mysqli_query($conn, $sql);

            if ($results) {

                $row = mysqli_fetch_assoc($results);
				if ($row) {
					
					if ($row["password"] === $password) { 
                        $_SESSION["username"] = $username;

                        $_SESSION["user_id"] = $row["user_id"];


                        if ($row['is_employee'] != 0){
                            $_SESSION["is_employee"] = true;
                            
                            header("Location: ../templates/managerpage.php");
                            exit();

                        } else {
                            $_SESSION["is_employee"] = false;
                        }         
                        
						$sql = "SELECT * FROM users";
						$results = mysqli_query($conn, $sql);
						echo "<br>SUCCESS: You have logged in!";
                        header("Location: ../templates/home.php");
                        exit();
					} else {
						echo "FAILED: Password is incorrect!";
                        $_SESSION["login_error"] = "Password incorrect";
					}
				} else {
					echo "username could not be found, please <a href='../templates/register.php'>REGISTER</a>!";
                    $_SESSION["login_error"] = "Username could not be found";
				}

            } else {
				$_SESSION["login_error"] = "Username could not be found";
                echo mysqli_error($conn);
            }

            mysqli_close($conn);

        } else {
            echo "Username or Password is empty.";
            $_SESSION["login_error"] = "Username or password empty";
        }
    } else {
        $_SESSION["login_error"] = "Username or password empty";
        
    }
    header("Location: ../templates/login.php");
        exit();


?>
