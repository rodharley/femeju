<?php
$menu = 19;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$galeria = new Galeria();

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                                    <h1>
                                        Galeria
                                        <small>Pesquisa</small>
                                    </h1>
                                    <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_galeria-main"><i class="fa fa-file-image-o"> </i> Galeria</a></li>
                                        <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/galeria/edit.html");


$TPL->LABEL = "Nova Galeria";
$TPL->ACAO = "incluir";
$TPL->id = 0;
if(isset($_REQUEST['id'])){
	$galeria->getById($galeria->md5_decrypt($_REQUEST['id']));
	$TPL->titulo = $galeria->titulo;
    $TPL->data = $galeria->convdata(substr($galeria->data,0,10),"mtn");
	$TPL->id = $galeria->id;
	$TPL->LABEL = "Alterar Galeria ".$galeria->titulo;
	$TPL->ACAO = "editar";
}

$TPL->show();
?>