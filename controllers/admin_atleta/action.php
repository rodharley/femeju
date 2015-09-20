<?php
$menu = 28;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Associacao();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$obj->Alterar();
        $_SESSION['fmj.mensagem'] = 38;
        header("Location:admin_associacao-main");
        exit();
		break;
	case 'incluir' :
		$obj->Incluir();
        $_SESSION['fmj.mensagem'] = 37;
        header("Location:admin_associacao-main");
        exit();
		break;
	case 'excluir' :
		$obj->Excluir($_REQUEST['id']);
        header("Location:admin_associacao-main");
        exit();
		break;		
}
}
?>