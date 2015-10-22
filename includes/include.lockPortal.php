<?php
if(!isset($_SESSION['fmj.userId'])){
	$_SESSION['fmj.mensagem'] = 23;	
    header("Location:portal_servicos-entrar");
	exit();
}
$now = time();
if ($now > $_SESSION['expire']) {    
    session_destroy();  
    session_start();
    $_SESSION['fmj.mensagem'] = 56;
    header("Location:portal_servicos-entrar");

}else{
    $_SESSION['start'] = time(); // Taking now logged in time.
    $_SESSION['expire'] = $_SESSION['start'] + (1800);
}