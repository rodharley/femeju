<?php
$post = new Post();
$idcat = $post->md5_decrypt($_REQUEST['categoria']); 
$menu = $idcat;
 
include("includes/include.lock.php");
//INSTACIA CLASSES
$objCat = new Categoria($idcat);
$objEmail = new Email();

//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$post->Alterar();
		$_SESSION['fmj.mensagem'] = 27;
        $objEmail->enviarEmailPush("Alteraчуo de Post:".$objCat->retornaDescricao($idcat)." - ".$_REQUEST['titulo']);
        break;
	case 'incluir' :
		$post->Incluir();
        $_SESSION['fmj.mensagem'] = 26;
        $objEmail->enviarEmailPush("Inclusуo de Post:".$objCat->retornaDescricao($idcat)." - ".$_REQUEST['titulo']);
        break;
	case 'excluir' :
        $post->getById($_REQUEST['id']);
		if($post->Excluir($_REQUEST['id'])){
        $_SESSION['fmj.mensagem'] = 28;
        $objEmail->enviarEmailPush("Exclusуo de Post:".$objCat->retornaDescricao($post->id)." - ".$post->titulo);
        }else
        $_SESSION['fmj.mensagem'] = 17;        
        break;		
}

}
header("Location:admin_post-".$objCat->retornaPasta($objCat->id));
exit();
?>