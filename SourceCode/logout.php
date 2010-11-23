<?php
session_start();
$_SESSION['user_sc']="";
setcookie("user_sc","");
$_COOKIE['user_sc']="";
header( 'Location: index.php' ) ;
session_unset(); 


session_destroy(); 
?>