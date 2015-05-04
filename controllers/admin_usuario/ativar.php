<?php

$TPL = NEW Template("templates/index.html");
$TPL->addFile("CONTEUDO", "templates/usuario/ativar.html");
$user = new Usuario();
if(isset($_REQUEST['id'])){
$idUser = $user->md5_decrypt($_REQUEST['id']);	
$user->getById($idUser);	
	if($user->id == null){
		$_SESSION['grc.mensagem'] = 1;
		header("Location:index.php");
		exit();
	}else{
		if($user->ativo == "0"){
				$TPL->id = $user->id;
		}else{
			$_SESSION['grc.mensagem'] = 61;
			header("Location:index.php");
			exit();
		
		}
	}
}else{
	$_SESSION['grc.mensagem'] = 1;
		header("Location:index.php");
		exit();
}
$TPL->show();
?>