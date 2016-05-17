<?php  
require "degiskenler.php";

if (isset($_COOKIE[COOKIE1]) || isset($_COOKIE[COOKIE1])) 
{	
	unset($_COOKIE[COOKIE1]);
	unset($_COOKIE[COOKIE2]);
	setcookie(COOKIE1,"",time()-3600);
	setcookie(COOKIE2,"",time()-3600);
}
header('Location: index.php');
?>