<?php 
$user = new Usuario();
if(isset($_REQUEST['id'])){
$idUser = $_REQUEST['id'];
$user->getById($idUser);
	if($user->id != null){
		if($user->ativo == "0"){
			$user->ativo = 1;
			$user->senha = md5($_REQUEST['senha']);
			$user->save();
			$_SESSION['fmj.mensagem'] = 14;
			$user->login($user->email, $_POST['senha']);
			header("Location:portal_servicos-main");
			exit();
		}else{
		$_SESSION['fmj.mensagem'] = 13;
		header("Location:portal_servicos-entrar");
		exit();
		}
	}else{
		$_SESSION['fmj.mensagem'] = 1;
		header("Location:portal_servicos-entrar");
		exit();
	}
}else{
	$_SESSION['fmj.mensagem'] = 1;
		header("Location:portal_servicos-entrar");
		exit();
}

?>