<?php
$menu = 3;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Perfil
                        <small>Edi��o de Perfil</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="perfil-listar"><i class="fa fa-home"> </i> Perfis</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/perfil/edit.html");
$obj = new Perfil();
$objAcesso = new Acesso();
$objMenu = new Menu();

$TPL->LABEL = "Incluir Perfil";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$arrayMenusSelecionados = array();


if(isset($_REQUEST['id'])){
    $TPL->LABEL = "Editar Perfil";
    $TPL->ACAO = "editar";
    $TPL->id = $_REQUEST['id'];
    $obj->getById($obj->md5_decrypt($_REQUEST['id']));
    $TPL->nome = $obj->descricao;
    
    $listaAcessos = $objAcesso->recuperaMenuAcessos($obj->id);
    
    foreach($listaAcessos as $key => $m){
    	$arrayMenusSelecionados[] = $m->menu->id;
    }
}


$menus = $objMenu->recuperaMenusCompletos(0);
 foreach($menus as $key => $m){
 	$TPL->DESC_MENU = $m->nome;
	$TPL->IDMENU = $m->id;
	if(in_array($m->id, $arrayMenusSelecionados))
		$TPL->CHECKMENU = 'checked="checked"';
	$submenus = $objMenu->recuperaMenusCompletos($m->id);
 	foreach($submenus as $key2 => $sm){
		$TPL->DESC_SUBMENU_MENU = $sm->nome;
		$TPL->IDSUBMENU = $sm->id;
		if(in_array($sm->id, $arrayMenusSelecionados))
		$TPL->CHECKSUBMENU = 'checked="checked"';
		$TPL->block("BLOCK_SUB_ITEM");
		$TPL->clear('CHECKSUBMENU');
	}
 	$TPL->block("BLOCK_ITEM");
	$TPL->clear('CHECKMENU');
 }


$TPL->show();
?>