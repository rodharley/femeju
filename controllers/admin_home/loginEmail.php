<?php
$user = new Usuario();

if($user->loginMd5($_GET['gests'],$_GET['gestp'])){	
	header("Location:"+$_GET['gestu']);
	exit();
}else{	
	header("Location:index.php");
}

?>
