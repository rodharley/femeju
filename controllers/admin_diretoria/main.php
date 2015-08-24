<?php
$menu = 4;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$diretoria = new Diretoria();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Diretoria
                        <small>Lista de Diretorias</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_perfil-main"><i class="fa fa-users"> </i> Diretoria</a></li>
                                         <li class="active">Listar</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/diretoria/list.html");



$alist = $diretoria->getRows();
$TPL->QUANTIDADE = count($alist);
foreach($alist as $key => $diretoriaario){
	$TPL->descricao = $diretoriaario->descricao;
	$TPL->responsavel = $diretoriaario->usuario->pessoa->nome;
	$TPL->ID_HASH = $diretoria->md5_encrypt($diretoriaario->id);
	$TPL->block("BLOCK_ITEM_LISTA");
}

$TPL->show();
?>