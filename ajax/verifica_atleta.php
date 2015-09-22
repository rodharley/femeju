<?php
$menu = 0;
include("configuraAjaxSemLogin.php");

	$obAtleta = new Atleta();
	$id = isset($_REQUEST['idPessoa']) ? $_REQUEST['idPessoa'] == "" ? "0" : $_REQUEST['idPessoa']  : "0";
	echo json_encode (!$obAtleta->recuperaPorIdPessoa($id));	
?>