<?php
$menu = 6;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Post();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$obj->Alterar();
		$_SESSION['fmj.mensagem'] = 27;
        break;
	case 'incluir' :
		$obj->Incluir();
        $_SESSION['fmj.mensagem'] = 26;
        break;
	case 'excluir' :
		if($obj->Excluir($_REQUEST['id']))
        $_SESSION['fmj.mensagem'] = 28;
        else
        $_SESSION['fmj.mensagem'] = 17;        
        break;		
}
}
header("Location:admin_calendario-main");
exit();
?>