<?php
$user = new Usuario();

if($user->login($_POST['login'], $_POST['senha'])){
    	if(isset($_POST['url']) && strlen($_POST['url']) > 0)    	
        header("Location:".$_POST['url']);
        else
    	header("Location:home-home");
	exit();
}else{	
	header("Location:index.php");
}

?>
