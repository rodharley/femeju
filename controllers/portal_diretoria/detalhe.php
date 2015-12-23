<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/diretoria/detalhe.html");
$obj = new Post();
$obj->getById($obj->md5_decrypt($_REQUEST['id']));
$objDir = new Diretoria();
$objDir->getById($obj->categoria);
$TPL->categoria = $objDir->descricao;
$TPL->pasta = "diretoria";
$TPL->imagem = $obj->imagem;
$TPL->titulo = $obj->titulo;
$TPL->texto = $obj->texto;
$TPL->mensagem = $obj->mensagem;
$TPL->ID_HASH = $obj->md5_encrypt($objDir->id);
$TPL->data = $obj->convdata($obj->data,"mtnh");
if($obj->imagem != "")
    $TPL->block("BLOCK_IMG");
if($obj->arquivo != ""){
        $TPL->post_link = "documentos/".$objCat->pasta."/".$obj->arquivo;
        $TPL->post_tipoArquivo = "fb_".$obj->retornaTipo($obj->arquivo);
        $TPL->post_arquivo = $obj->arquivo;
        $TPL->block("BLOCK_POST_ARQUIVO");
    }
$TPL->show();
?>