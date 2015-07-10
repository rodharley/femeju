<?php
$post = new Post();
$idcat = $post->md5_decrypt($_REQUEST['categoria']); 
$menu = $idcat;
 
include("includes/include.lock.php");
//INSTACIA CLASSES
$objCat = new Categoria($idcat);
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$post->Alterar();
		$_SESSION['fmj.mensagem'] = 27;
        break;
	case 'incluir' :
		$post->Incluir();
        $_SESSION['fmj.mensagem'] = 26;
        break;
	case 'excluir' :
		if($post->Excluir($_REQUEST['id']))
        $_SESSION['fmj.mensagem'] = 28;
        else
        $_SESSION['fmj.mensagem'] = 17;        
        break;		
}
}
header("Location:admin_post-".$objCat->retornaPasta($objCat->id));
exit();
?>