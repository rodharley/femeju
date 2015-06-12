<?php
if(!isset($_SESSION['fmj.menu'])){
	$_SESSION['fmj.mensagem'] = 23;	
	header("Location:portal_servicos-entrar");
	exit();
}

?>