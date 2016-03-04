<?php

$TPL = NEW Template("templates/admin/index.html");
$TPL->addFile("CONTEUDO", "templates/admin/usuario/ativar.html");
$user = new Usuario();
if(isset($_REQUEST['id'])){
$idUser = $user->md5_decrypt($_REQUEST['id']);
  	
$user->getById($idUser);	
	if($user->id == null){
		$_SESSION['fmj.mensagem'] = 1;
		header("Location:admin_home-index");
		exit();
	}else{
		if($user->ativo == "0"){
				$TPL->id = $user->id;
                $TPL->email = $user->pessoa->email;
		}else{
			$_SESSION['fmj.mensagem'] = 13;
			header("Location:admin_home-index");
			exit();
		
		}
	}
}else{
	$_SESSION['fmj.mensagem'] = 1;
		header("Location:admin_home-index");
		exit();
}
$TPL->show();
?>