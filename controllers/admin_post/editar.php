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
			                            <small>Edita Post</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_post-'.$objCat->retornaPasta($objCat->id).'"><i class="fa fa-comment"> </i> '.$objCat->retornaDescricao($objCat->id).'</a></li>
			                            <li class="active">Editar</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/post/edit.html");
$pasta = $objCat->retornaPasta($idcat);

$TPL->ID_CATEGORIA_HASH = $post->md5_encrypt($idcat);
$TPL->LABEL = "Novo Post";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->IMG_IMAGEM = "";
$TPL->IMG_ARQUIVO = "";

if(isset($_REQUEST['id'])){
	$post->getById($post->md5_decrypt($_REQUEST['id']));
	$TPL->id = $post->id;
	$TPL->titulo = $post->titulo;
    $TPL->mensagem = $post->mensagem;
    $TPL->texto = $post->texto;
    $TPL->ordem = $post->ordem;
	$TPL->data = $post->convdata(substr($post->data,0,10),"mtn");
	$TPL->IMG_IMAGEM = "img/".$pasta."/".$post->imagem;
    $TPL->IMG_ARQUIVO = "img/".$pasta."/".$post->arquivo;
	$TPL->LABEL = "Alterar Post ";
	$TPL->ACAO = "editar";
	if(strlen($post->imagem) > 0){
		$TPL->IMG_IMAGEM = "<input type='hidden' value='1' name='haveimagem'/><img src='img/".$pasta."/".$post->imagem."' class='file-preview-image' alt='".$post->imagem."' title='".$post->imagem."'>";
		$TPL->block("BLOCK_IMG");
	}
    if(strlen($post->arquivo) > 0){
        $TPL->IMG_ARQUIVO = "<input type='hidden' value='1' name='havearquivo'/><img src='img/".$pasta."/".$post->arquivo."' class='file-preview-image' alt='".$post->arquivo."' title='".$post->arquivo."'>";
        $TPL->block("BLOCK_ARQ");
    }
   
	
}else{
    
}

$TPL->show();
?>