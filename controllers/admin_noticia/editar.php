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
			                            Usuários
			                            <small>Edita Usuário</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
			                            <li><a href="admin_noticia-main"><i class="fa fa-newspaper-o"> </i> Notícias</a></li>
			                            <li class="active">Editar</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/noticia/edit.html");


$TPL->LABEL = "Nova Notícia";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->IMG_NOTICIA = "";
$TPL->checkedNenhum = "checked='checked'";
$TPL->checkedEsquerdo = "";
$TPL->checkedDireito = "";
$TPL->checkedPC = "";
$TPL->checkedD = "";
$TPL->checkedN = "";
$TPL->checkedP = "";
$TPL->checkedDI = "";

if(isset($_REQUEST['id'])){
	$noticia->getById($noticia->md5_decrypt($_REQUEST['id']));
	$TPL->titulo = $noticia->titulo;
	$TPL->texto = $noticia->texto;
	$TPL->id = $noticia->id;
	$TPL->IMG_NOTICIA = "img/noticias/".$noticia->foto;
	$TPL->LABEL = "Alterar Notícia ".$noticia->titulo;
	$TPL->ACAO = "editar";
	if(strlen($noticia->foto) > 0){
		$TPL->IMG_NOTICIA = "<img src='img/noticias/".$noticia->foto."' class='file-preview-image' alt='".$noticia->foto."' title='".$noticia->foto."'>";
		$TPL->block("BLOCK_IMG");
	}

    if($noticia->principal == 1){
        $TPL->checkedEsquerdo = "checked='checked'";
        $TPL->checkedNenhum = "";        
    }
    
    if($noticia->principal == 2){
        $TPL->checkedDireito = "checked='checked'";
        $TPL->checkedNenhum = "";
    }
    if($noticia->principal == 3){
        $TPL->checkedPC = "checked='checked'";
        $TPL->checkedNenhum = "";
    }
    if($noticia->principal == 4){
        $TPL->checkedD = "checked='checked'";
        $TPL->checkedNenhum = "";
    }
    if($noticia->principal == 5){
        $TPL->checkedN = "checked='checked'";
        $TPL->checkedNenhum = "";
    }
    if($noticia->principal == 6){
        $TPL->checkedP = "checked='checked'";
        $TPL->checkedNenhum = "";
    }
    if($noticia->principal == 7){
        $TPL->checkedDI = "checked='checked'";
        $TPL->checkedNenhum = "";
    }
	
}

$TPL->show();
?>