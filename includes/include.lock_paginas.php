<?php
switch ($_SESSION['pr.userPerfil']) {
	case '1':
	break;	
	case '2':
	$apag = explode("/", $_SERVER['REQUEST_URI']);
	$pagina = $apag[count($apag)-1];
	if($pagina == 'programa_novo.php' || $pagina == 'usuario_novo.php'){
	$root->setMensagem(6);	
	header("Location:index.php");
	exit();
	}		
	break;	
	default:
	$root->setMensagem(6);	
	header("Location:index.php");
	exit();	
	break;
}

?>