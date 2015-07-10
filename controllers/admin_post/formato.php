<?php
$post = new Post();
$idcat = $post->md5_decrypt($_REQUEST['categoria']); 
$menu = $idcat; 
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$objCat = new Categoria($idcat);

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            '.$objCat->retornaDescricao($objCat->id).'
			                            <small>Post</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_post-'.$objCat->retornaPasta($objCat->id).'"><i class="fa fa-comment"> </i> '.$objCat->retornaDescricao($objCat->id).'</a></li>
			                            <li class="active">Formato</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/post/formato.html");
$TPL->ID_CATEGORIA_HASH = $_REQUEST['categoria'];
$TPL->show();
?>