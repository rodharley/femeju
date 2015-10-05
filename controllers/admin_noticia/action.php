<?php
$menu = 1;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Noticia();
$objEmail = new Email();
//ACOES
if(isset($_REQUEST['acao'])){
    
switch ($_REQUEST['acao']){
	case 'editar' :
 		$obj->Alterar();
        $objEmail->enviarEmailPush("Alteração de Notícia: ".$_REQUEST['titulo']);
		$_SESSION['fmj.mensagem'] = 19;
        header("Location:admin_noticia-main");
        break;
        
	case 'incluir' :
		$obj->Incluir();
        $objEmail->enviarEmailPush("Inclusão de Notícia: ".$_REQUEST['titulo']);
        $_SESSION['fmj.mensagem'] = 18;
        header("Location:admin_noticia-main");
        
        break;
	case 'excluir' :
        $obj->getById($obj -> md5_decrypt($_REQUEST['id']));
		$obj->Excluir($_REQUEST['id']);
        $objEmail->enviarEmailPush("Exclusão de Notícia: ".$obj->titulo);
        header("Location:admin_noticia-main");
        
		break;		
}
}
exit();
?>