<?php
$post = new Post();
$diretoria = new Diretoria();
if(!$diretoria->getByResponsavel($_SESSION['fmj.userId'])){
    $_SESSION['fmj.mensagem'] = 36;
    header("Location:admin_home-home");
    exit();
}
$menu = 23; 
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                                    <h1>
                                        '.$diretoria->descricao.'
                                        <small>Edita Post</small>
                                    </h1>
                                    <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_diretoria-posts"><i class="fa fa-comment"> </i>Posts</a></li>
                                        <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/diretoria/edit_post.html");
$pasta = "diretoria";

$TPL->ID_CATEGORIA_HASH = $post->md5_encrypt($diretoria->id);
$TPL->LABEL = "Novo Post";
$TPL->ACAO = "incluir_post";
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
    $TPL->ACAO = "editar_post";
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