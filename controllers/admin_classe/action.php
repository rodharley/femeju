<?php
$menu =29;
include("includes/include.lock.php");
//INSTACIA CLASSES
$grad = new Classe();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$grad->Alterar();
		 $_SESSION['fmj.mensagem'] = 58;
        header("Location:admin_classe-main");
        exit();
		break;
     case 'incluir' :
        $grad->Incluir();
		  $_SESSION['fmj.mensagem'] = 57;
        header("Location:admin_classe-main");
        exit();
        break;
	case 'excluir' :
        $grad->Excluir($_REQUEST['id']);
		header("Location:admin_classe-main");
        exit();
        break;  	
}
}

?>