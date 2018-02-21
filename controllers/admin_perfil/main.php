<?php
$menu = 3;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$perfil = new Perfil();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Perfil
                        <small>Lista de Perfis</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_perfil-main"><i class="fa fa-users"> </i> Perfil</a></li>
                                         <li class="active">Listar</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/perfil/list.html");



$alist = $perfil->getRows();
$TPL->QUANTIDADE = count($alist);
foreach($alist as $key => $perfilario){
	$TPL->disabled = "";    
	$TPL->nome = $perfilario->descricao;
	$TPL->ID_HASH = $perfil->md5_encrypt($perfilario->id);
    if($perfilario->id == Perfil::ADMINISTRADOR || $perfilario->id == Perfil::EXTERNO || $perfilario->id == Perfil::ARBITRAGEM)
    $TPL->disabled = "disabled";
	$TPL->block("BLOCK_ITEM_LISTA");
}

$TPL->show();
?>