<?php
$menu = 0;
include("includes/include.lock.php");
//INSTACIA CLASSES
$usu = new Usuario();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$usu->Alterar();
		break;
	case 'incluir' :
		$usu->Incluir();
		break;
	case 'excluir' :
		$usu->Excluir($_REQUEST['id']);
		break;
	case 'redefinir':
		$usu->Redefinir($_REQUEST['id']);
		break;	
	case 'meusDados' :
		$usu->AlterarMeusDados();
		break;	
}
}
?>