<?php
$menu =29;
include("includes/include.lock.php");
//INSTACIA CLASSES
$grad = new Graduacao();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$grad->Alterar();
		 $_SESSION['fmj.mensagem'] = 48;
        header("Location:admin_graduacao-main");
        exit();
		break;
     case 'incluir' :
        $grad->Incluir();
		  $_SESSION['fmj.mensagem'] = 47;
        header("Location:admin_graduacao-main");
        exit();
        break;
	case 'excluir' :
        $grad->Excluir($_REQUEST['id']);
		header("Location:admin_graduacao-main");
        exit();
        break;  	
}
}

?>