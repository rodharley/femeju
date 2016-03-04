<?php 
$TPL = NEW Template("templates/admin/index.html");
$TPL->addFile("CONTEUDO", "templates/admin/usuario/ativar.html");
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
			$user->login($user->pessoa->email, $_POST['senha']);
			header("Location:admin_home-home");
			exit();
		}else{
		$_SESSION['fmj.mensagem'] = 13;
		header("Location:admin_home-index");
		exit();
		}
	}else{
		$_SESSION['fmj.mensagem'] = 1;
		header("Location:admin_home-index");
		exit();
	}
}else{
	$_SESSION['fmj.mensagem'] = 1;
		header("Location:admin_home-index");
		exit();
}
$TPL->show();
?>