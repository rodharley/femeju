<?php
$menu = 5;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Atleta();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$obj->Alterar();
		break;
	case 'incluir' :
		$obj->Incluir();
		break;
	case 'excluir' :
		$obj->Excluir($_REQUEST['id']);
		break;		
}
}
?>