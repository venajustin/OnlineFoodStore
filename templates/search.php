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
        if ($result = $mysqli->query($query)) {

            /* fetch associative array */
            while ($row = $result->fetch_assoc()) {
                $field1name = $row["col1"];
                $field2name = $row["col2"];
                $field3name = $row["col3"];
                $field4name = $row["col4"];
                $field5name = $row["col5"];
                echo $field2name;
                echo "<br>";
            }
        
            /* free result set */
            $result->free();
        }
        exit();
    
        }
    

    // search call (see if the exact word is contained in the database)
    

?>