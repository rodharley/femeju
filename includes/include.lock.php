<?php
if(!isset($_SESSION['grc.menu'])){
	$_SESSION['grc.mensagem'] = 6;	
	header("Location:index.php");
	exit();
}
$armenus = explode(",",$_SESSION['grc.menu']);
if(!in_array($menu, $armenus)){
	$_SESSION['grc.mensagem'] = 7;	
	header("Location:index.php");
	exit();
}

?>