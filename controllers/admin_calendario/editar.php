<?php
$menu = 6;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$post = new Post();
$formato = new Formato();
$objCat = new Categoria();
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Calendário
			                            <small>Edita Post</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
			                            <li><a href="admin_noticia-main"><i class="fa fa-calendar"> </i> Calendário</a></li>
			                            <li class="active">Editar</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/post/edit.html");
$CodCategoria = Categoria::CALENDARIO;
$pasta = $objCat->retornaPasta($CodCategoria);

$TPL->ID_CATEGORIA = $CodCategoria;
$TPL->LABEL = "Novo Post";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->IMG_IMAGEM = "";
$TPL->IMG_ARQUIVO = "";
$TPL->titulo_required = "";
$TPL->mensagem_required = "";
$TPL->arquivo_required = "";
$TPL->foto_required = "";




if(isset($_REQUEST['id'])){
	$post->getById($post->md5_decrypt($_REQUEST['id']));
	$codFormato = $post->formato;
    $TPL->id = $post->id;
	$TPL->titulo = $post->titulo;
    $TPL->mensagem = $post->mensagem;
	$TPL->data = $post->convdata(substr($post->data,0,10),"mtn");
	
	$TPL->IMG_IMAGEM = "img/".$pasta."/".$post->imagem;
    $TPL->IMG_ARQUIVO = "img/".$pasta."/".$post->arquivo;
	$TPL->LABEL = "Alterar Post ";
	$TPL->ACAO = "editar";
	if(strlen($post->imagem) > 0){
		$TPL->IMG_IMAGEM = "<img src='img/".$pasta."/".$post->imagem."' class='file-preview-image' alt='".$post->imagem."' title='".$post->imagem."'>";
		$TPL->block("BLOCK_IMG");
	}
    if(strlen($post->arquivo) > 0){
        $TPL->IMG_ARQUIVO = "<img src='img/".$pasta."/".$post->arquivo."' class='file-preview-image' alt='".$post->arquivo."' title='".$post->arquivo."'>";
        $TPL->block("BLOCK_ARQ");
    }
   
	
}else{
    $codFormato = $_REQUEST['formato'];
}

$TPL->ID_FORMATO  = $codFormato;
$TPL->FORMATO = $formato->retornaTemplate($codFormato,"img/judo-2.jpg","Título de Teste", "Mensagem de teste.","http://www.google.com.br","fb_txt","arquivo.txt");
//verifica as validacoes do formulario
switch ($codFormato) {
    case '1':
        $TPL->titulo_required = "required";
        $TPL->arquivo_required = "required";
        break;
    case '2':
        $TPL->arquivo_required = "required";
        break;
    case '3':
        $TPL->titulo_required = "required";
        $TPL->mensagem_required = "required";
        $TPL->foto_required = "required";
        break;
    case '4':
        $TPL->titulo_required = "required";
        $TPL->mensagem_required = "required";
        break;
    default:
        
        break;
}


$TPL->show();
?>