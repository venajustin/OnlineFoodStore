<?php
    $hostname = 'onlinefoodstore.c2zn58sjaobh.us-west-1.rds.amazonaws.com';
    $dbuser = 'server';
    $dbpass = 'Kiifne9283';
    $dbname = 'onlinefoodstore';


    // create connection 
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);

    // check connection 
    if (!$conn) { 
        die ("Connection failed: " . mysqli_connect_error());
    } else {
        echo "connection sucess";
    }
    

?>