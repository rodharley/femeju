<?php
$menu =36;
include("includes/include.lock.php");
//INSTACIA CLASSES
$grad = new CategoriaPeso();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$grad->Alterar();
		 $_SESSION['fmj.mensagem'] = 58;
        header("Location:admin_categoria-main?idClasse=".$grad->md5_encrypt($_REQUEST['idClasse']));
        exit();
		break;
     case 'incluir' :
        $grad->Incluir();
		  $_SESSION['fmj.mensagem'] = 57;
        header("Location:admin_categoria-main?idClasse=".$grad->md5_encrypt($_REQUEST['idClasse']));
        exit();
        break;
	case 'excluir' :
        $grad->Excluir($_REQUEST['id']);
		header("Location:admin_categoria-main?idClasse=".$grad->md5_encrypt($_REQUEST['idClasse']));
        exit();
        break;  	
}
}

?>