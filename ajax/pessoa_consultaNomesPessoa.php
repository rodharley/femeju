<?php
$menu = 0;
include("configuraAjaxSemLogin.php");

	$obUsuario = new Pessoa();
	if($obUsuario->ConsultaNomesPessoa($_REQUEST['nome'],$_REQUEST['nomeMeio'],$_REQUEST['sobrenome']))
	echo "1";
	else
	echo "0";
?>