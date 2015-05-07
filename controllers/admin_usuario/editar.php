<?php
$menu = 2;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
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
			                             <li><a href="admin_home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
			                            <li><a href="admin_usuario-main"><i class="fa fa-user"> </i> Usuários</a></li>
			                            <li class="active">Editar</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/usuario/edit.html");


$TPL->LABEL = "Novo Usuário";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->checksim = "checked='checked'";
$TPL->checknao = "";
$TPL->IMG_USER = "img/users/avatar.png";
$TPL->carregando = $usu->carregando;
$idPerfilUsu = 0;
if(isset($_REQUEST['id'])){
	$usu->getById($usu->md5_decrypt($_REQUEST['id']));
	$TPL->cpf = $usu->cpf;
	$TPL->nome = $usu->nome;
	$TPL->email = $usu->email;
	$TPL->telefone = $usu->telefone;
	$TPL->celular = $usu->celular;
	$TPL->senha = "";
	$TPL->id = $usu->id;
	$idPerfilUsu = $usu->perfil->id;
	$TPL->IMG_USER = "img/users/".$usu->foto;
	$TPL->LABEL = "Alterar Usuário ".$usu->nome;
	$TPL->ACAO = "editar";

	if($usu->ativo == "0"){
	$TPL->checknao = "checked='checked'";
	$TPL->checksim = "";
	}


	if(strlen($usu->foto) > 0){
		$TPL->IMG_USER = "<img src='img/users/".$usu->foto."' class='file-preview-image' alt='".$usu->foto."' title='".$usu->foto."'>";
		$TPL->block("BLOCK_IMG");
	}

	$TPL->block("BLOCK_EDIT");
}
$perfil = new Perfil();
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