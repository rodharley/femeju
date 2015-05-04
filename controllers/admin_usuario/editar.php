<?php
$menu = 2;
include("includes/include.lock.php");
$TPL = NEW Template("templates/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$usu = new Usuario();

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usuários
			                            <small>Edita Usuário</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="usuario-listar"><i class="fa fa-dashboard"> </i> Usuários</a></li>
			                            <li class="active">Editar</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------


//verificar se perfil selecionado
if(!isset($_REQUEST['idPerfil'])){
	$_SESSION['grc.mensagem'] = 64;
	header("Location:usuario-perfil");
	exit();
}
$idPerfil = $usu->md5_decrypt($_REQUEST['idPerfil']);

if($_SESSION['grc.userPerfilId'] > 0){
if($idPerfil == "" || $idPerfil < $_SESSION['grc.userPerfilId']){
	$_SESSION['grc.mensagem'] = 7;
	header("Location:usuario-perfil");
	exit();
}
}


if($_SESSION['grc.empresaId'] != 0  && !isset($_REQUEST['id'])){
$maximo = 0;
$objEmpresa = new Empresa();
$objEmpresa->getById($_SESSION['grc.empresaId']);
if($idPerfil == Perfil::ENG_ADM)
		$maximo = $objEmpresa->qtdEngAdm;
	if($idPerfil == Perfil::ENG_MAN)
		$maximo = $objEmpresa->qtdEngMan;

$totalGeral = $usu->recuperaTotalPerfil($idPerfil);
if($totalGeral >= $maximo && $maximo != 0){
	$_SESSION['grc.mensagem'] = 65;
	header("Location:usuario-perfil");
	exit();
}
}

$TPL->addFile("CONTEUDO", "templates/usuario/edit.html");


$idPerfilUsu = $idPerfil;
$TPL->LABEL = "Novo Usuário";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->checksim = "checked='checked'";
$TPL->checknao = "";
$TPL->IMG_USER = "img/users/avatar.png";
$TPL->ASS_USER = "img/assinaturas/assinatura.jpg";
$TPL->carregando = $usu->carregando;
if(isset($_REQUEST['id'])){
	$usu->getById($usu->md5_decrypt($_REQUEST['id']));
	$TPL->cpf = $usu->cpf;
	$TPL->nome = $usu->nome;
	$TPL->login = $usu->login;
	$TPL->email = $usu->email;
	$TPL->telefone = $usu->telefone;
	$TPL->celular = $usu->celular;
	$TPL->senha = "";
	$TPL->id = $usu->id;
	$idPerfilUsu = $usu->perfil->id;
	$TPL->IMG_USER = "img/users/".$usu->foto;
	$TPL->ASS_USER = "img/assinaturas/".$usu->assinatura;
	$TPL->LABEL = "Alterar Usuário ".$usu->nome;
	$TPL->ACAO = "editar";

	if($usu->ativo == "0"){
	$TPL->checknao = "checked='checked'";
	$TPL->checksim = "";
	}

	if(strlen($usu->assinatura) > 0){
		$TPL->ASS_USER = "<img src='img/assinaturas/".$usu->assinatura."' class='file-preview-image' alt='".$usu->assinatura."' title='".$usu->assinatura."' width='140'>";
		$TPL->block("BLOCK_ASS");
	}

	if(strlen($usu->foto) > 0){
		$TPL->IMG_USER = "<img src='img/users/".$usu->foto."' class='file-preview-image' alt='".$usu->foto."' title='".$usu->foto."'>";
		$TPL->block("BLOCK_IMG");
	}

	$TPL->block("BLOCK_EDIT");
}
$perfil = new Perfil();
if($_SESSION['grc.userPerfilId'] > 0)
$rsPerfil = $perfil->getRows(0,999,array(),array("id"=>" >= ".$_SESSION['grc.userPerfilId']));
else
$rsPerfil = $perfil->getRows(0,999,array("id"=>"asc"),array());
 foreach($rsPerfil as $key => $p){
 	$TPL->idItem = $p->id;
	$TPL->labelItem = $p->descricao;
	if($p->id == $idPerfilUsu)
		$TPL->checkItem = "selected";
	else
		$TPL->checkItem = "";
	$TPL->block("BLOCK_ITEM");
 }



$TPL->show();
?>