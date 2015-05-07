<?php
$menu = 1;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$noticia = new Noticia();

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usu�rios
			                            <small>Edita Usu�rio</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
			                            <li><a href="admin_noticia-main"><i class="fa fa-newspaper-o"> </i> Not�cias</a></li>
			                            <li class="active">Editar</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/noticia/edit.html");


$TPL->LABEL = "Nova Not�cia";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->IMG_NOTICIA = "";
if(isset($_REQUEST['id'])){
	$noticia->getById($noticia->md5_decrypt($_REQUEST['id']));
	$TPL->titulo = $noticia->titulo;
	$TPL->texto = $noticia->texto;
	$TPL->id = $noticia->id;
	$TPL->IMG_NOTICIA = "img/noticias/".$noticia->foto;
	$TPL->LABEL = "Alterar Not�cia ".$noticia->titulo;
	$TPL->ACAO = "editar";
	if(strlen($noticia->foto) > 0){
		$TPL->IMG_NOTICIA = "<img src='img/noticias/".$noticia->foto."' class='file-preview-image' alt='".$noticia->foto."' title='".$noticia->foto."'>";
		$TPL->block("BLOCK_IMG");
	}
	
}

$TPL->show();
?>