<?php
    $hostname = 'onlinefoodstore.c2zn58sjaobh.us-west-1.rds.amazonaws.com';
    $dbuser = 'server';
    $dbpass = 'Kiifne9283';
    $dbname = 'onlinefoodstore';


    // create connection 
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

    // check connection 
    $search = $_POST["search"];
    $searchq = "SELECT * FROM items WHERE item_description LIKE '%$search%'";
    $itemS = mysqli_query($conn,$searchq);
    if (!$conn ) { 
        die ("Connection failed: " . mysqli_connect_error());
    } 
    else {
        if ($itemS) {

            /* fetch associative array */
            while ($row = $itemS->fetch_assoc()) {
                $field1name = $row["item_id"];
                $field2name = $row["item_name"];
                $field3name = $row["item_description"];
                $field4name = $row["item_weight"];
                $field5name = $row["item_price"];
                echo "$field1name  $field2name  $field3name  $field4name $field5name";
                echo "<br>";
            }
        
            /* free result set */
            $itemS->free();
        }
        exit();
    
        }
    

    // search call (see if the exact word is contained in the database)
    

?>