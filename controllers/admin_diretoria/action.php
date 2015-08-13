<?php
$menu =4;
include("includes/include.lock.php");
//INSTACIA CLASSES
$diretoria = new Diretoria();
$post = new Post();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$diretoria->Alterar();
	break;
   case 'excluir' :
        $diretoria->Excluir($_REQUEST['id']);
   break;
   case 'incluir' :
        $diretoria->Incluir();
   break; 
   case 'editar_post' :
        $post->Alterar();
        $_SESSION['fmj.mensagem'] = 27;
        header("Location:admin_diretoria-posts");
    break;
    case 'incluir_post' :        
        $post->Incluir();
        $_SESSION['fmj.mensagem'] = 26;
        header("Location:admin_diretoria-posts");
     break;
    case 'excluir_post' :
        if($post->Excluir($_REQUEST['id']))
        $_SESSION['fmj.mensagem'] = 28;
        else
        $_SESSION['fmj.mensagem'] = 17;
        header("Location:admin_diretoria-posts");        
        break;      	
}
}

?>