<?php 
$TPL = NEW Template("templates/index.html");
$TPL->addFile("CONTEUDO", "templates/usuario/ativar.html");
$user = new Usuario();
if(isset($_REQUEST['id'])){
$idUser = $_REQUEST['id'];
$user->getById($idUser);
	if($user->id != null){
		if($user->ativo == "0"){
			$user->ativo = 1;
			$user->login = $_REQUEST['login'];
			$user->senha = md5($_REQUEST['senha']);
			$user->save();
			$_SESSION['grc.mensagem'] = 62;
			$user->login($_POST['login'], $_POST['senha']);
			header("Location:home-home");
			exit();
		}else{
		$_SESSION['grc.mensagem'] = 61;
		header("Location:index.php");
		exit();
		}
	}else{
		$_SESSION['grc.mensagem'] = 1;
		header("Location:index.php");
		exit();
	}
}else{
	$_SESSION['grc.mensagem'] = 1;
		header("Location:index.php");
		exit();
}
$TPL->show();
?>