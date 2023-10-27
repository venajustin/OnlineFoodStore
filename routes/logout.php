<?php
session_start();

session_destroy();
header('Location: '.$uri.'/OnlineFoodStore/templates/home.php');
exit;

?>