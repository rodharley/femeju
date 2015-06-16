<?php

$TPL = NEW Template("templates/admin/index.html");
$TPL->addFile("CONTEUDO", "templates/portal/servicos/ativar.html");
$user = new Usuario();
if(isset($_REQUEST['id'])){
$idUser = $user->md5_decrypt($_REQUEST['id']);
  	
$user->getById($idUser);	
	if($user->id == null){
		$_SESSION['fmj.mensagem'] = 1;
		header("Location:portal_servicos-entrar");
		exit();
	}else{
		if($user->ativo == "0"){
				$TPL->id = $user->id;
                $TPL->email = $user->email;
		}else{
			$_SESSION['fmj.mensagem'] = 13;
			header("Location:portal_servicos-entrar");
			exit();
		
		}
	}
}else{
	$_SESSION['fmj.mensagem'] = 1;
		header("Location:portal_servicos-entrar");
		exit();
}
$TPL->show();
?>