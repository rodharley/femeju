<?php
$menu = 0;
include("configuraAjaxSemLogin.php");

	$obUsuario = new Pessoa();
    $id = isset($_REQUEST['idUser']) ? strlen($_REQUEST['idUser']) > 0 ? $_REQUEST['idUser'] : "0" : "0";
	if($obUsuario->ConsultaNomesPessoa($_REQUEST['nome'],$_REQUEST['nomeMeio'],$_REQUEST['sobrenome'],$id))
	echo "1";
	else
	echo "0";
?>