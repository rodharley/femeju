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

?>