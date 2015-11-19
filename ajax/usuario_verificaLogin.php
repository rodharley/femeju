<?php
$menu = 0;
include("configuraAjaxSemLogin.php");

	$obUsuario = new Usuario();
	$login = $_REQUEST['email'];
	$id = isset($_REQUEST['idUser']) ? strlen($_REQUEST['idUser']) > 0 ? $_REQUEST['idUser'] : "0" : "0";
	$obUsuario->recuperaPorLogin($login,$id);
	if($obUsuario->id != null)
	echo json_encode (false); //Return the JSON Array
	else
	echo json_encode (true); //Return the JSON Array
?>