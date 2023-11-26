<?php 

session_start();

if (isset($_SESSION["username"])) {
    header('Location: '.$uri.'/OnlineFoodStore/templates/account.php');
} else {
    header('Location: '.$uri.'/OnlineFoodStore/templates/login.php');
}
exit;

?>