<?php
//INSTACIA CLASSES
$usu = new Usuario();
$atleta = new Atleta();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$usu->Alterar();
		break;
	case 'incluir' :
		$usu->IncluirPortal();
		break;
    case 'filiar' :
        $atleta->IncluirPortal();
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