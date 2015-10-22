<?php
if(!isset($_SESSION['fmj.menu'])){
	$_SESSION['fmj.mensagem'] = 6;	
	header("Location:admin_home-index");
	exit();
}

$armenus = explode(",",$_SESSION['fmj.menu']);
if(!in_array($menu, $armenus)){
	$_SESSION['fmj.mensagem'] = 7;	
	header("Location:admin_home-index");
	exit();
}
$now = time();
if ($now > $_SESSION['expire']) {    
    session_destroy();  
    session_start();
    $_SESSION['fmj.mensagem'] = 56;
    header("Location:admin_home-index");

}else{
    $_SESSION['start'] = time(); // Taking now logged in time.
    $_SESSION['expire'] = $_SESSION['start'] + (1800);
}
?>