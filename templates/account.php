<a href="../templates/home.php">HOME</a>
<br>
<h2>user account details and settings page</h2>
<br>
<?php

session_start();

echo "Signed in as: " . $_SESSION["username"] ;

if ($_SESSION["is_employee"]) {
    echo "<br>You are a manager of online food store!!!";
    echo "<br><a href='./managerpage.php'>MANAGER PAGE</a>";
}

    

?>
<br>
<a href="../routes/logout.php">Logout</a>


<br>
<br>
<br>
Debug Info - Session Variables:
<pre><?php print_r($_SESSION); ?></pre>
