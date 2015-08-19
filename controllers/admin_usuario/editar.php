<?php
$menu = 2;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$usu = new Usuario();
$lacademia = new Academia();
$perfil = new Perfil();
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usuários
			                            <small>Edita Usuário</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                             <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
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

$idPerfilUsu = 0;
$listaAcademias = array();
if(isset($_REQUEST['id'])){
	$usu->getById($usu->md5_decrypt($_REQUEST['id']));    
	$TPL->cpf = $usu->pessoa->cpf;
	$TPL->nome = $usu->pessoa->nome;
	$TPL->email = $usu->pessoa->email;
	$TPL->telefone = $usu->pessoa->telResidencial;
	$TPL->celular = $usu->pessoa->telCelular;
	$TPL->senha = "";
	$TPL->id = $usu->id;
	$idPerfilUsu = $usu->perfil->id;
	$TPL->IMG_USER = "img/users/".$usu->pessoa->foto;
	$TPL->LABEL = "Alterar Usuário ".$usu->pessoa->nome;
	$TPL->ACAO = "editar";

	if($usu->ativo == "0"){
	$TPL->checknao = "checked='checked'";
	$TPL->checksim = "";
	}


	if(strlen($usu->pessoa->foto) > 0){
		$TPL->IMG_USER = "<img src='img/users/".$usu->pessoa->foto."' class='file-preview-image' alt='".$usu->pessoa->foto."' title='".$usu->pessoa->foto."'>";
		$TPL->block("BLOCK_IMG");
	}
    
    /*/permissoes
    $rsPermissoes = $lacademia->listaPermissoes($usu->id);
    foreach ($rsPermissoes as $key => $permissao) {
        array_push($listaAcademias,$permissao->id);
    }*/
	$TPL->block("BLOCK_EDIT");
}

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

/*
$rsAcademias = $lacademia->getRows();
foreach ($rsAcademias as $key => $lacademia) {
    $TPL->idAcademia = $lacademia->id;
    $TPL->lblAcademia = $lacademia->nome;
    if(array_search($lacademia->id, $listaAcademias) !== false)
        $TPL->academiaChecked = 'checked="checked"';    
    $TPL->block("BLOCK_ACADEMIA");     
    $TPL->clear("academiaChecked");
}*/



$TPL->show();
?>