<?php
$menu = 0;
include("configuraAjaxSemLogin.php");

	$obUsuario = new Pessoa();
    $cpf = "";
    $cpf = isset($_REQUEST['cpf']) ? strlen($_REQUEST['cpf']) > 0 ? $_REQUEST['cpf'] : "" : "";
    if(strlen($cpf) == 0){ 
        $cpf = isset($_REQUEST['cpf_responsavel']) ? strlen($_REQUEST['cpf_responsavel']) > 0 ? $_REQUEST['cpf_responsavel'] : "" : "";
    }
	$login = $obUsuario->limpaDigitos($cpf);
	$id = isset($_REQUEST['idUser']) ? strlen($_REQUEST['idUser']) > 0 ? $_REQUEST['idUser'] : "0" : "0";
	if(strlen($login) > 0){	
	   if($obUsuario->ConsultaCPFExistente($login,$id))
	       echo json_encode (false); //Return the JSON Array
	   else
	       echo json_encode (true); //Return the JSON Array
    }else
        echo json_encode (true); //Return the JSON Array
?>