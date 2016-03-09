<?php
$menu = 0;
include("configuraAjaxSemLogin.php");

	$obUsuario = new Pessoa();
	$login = $obUsuario->limpaCpf($_REQUEST['cpf']);
	$id = isset($_REQUEST['idUser']) ? strlen($_REQUEST['idUser']) > 0 ? $_REQUEST['idUser'] : "0" : "0";
	if($obUsuario->ConsultaCPFExistente($login,$id))
	echo json_encode (false); //Return the JSON Array
	else
	echo json_encode (true); //Return the JSON Array
?>