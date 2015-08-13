<?php
$menu = 23; 
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$diretoria = new Diretoria();
if(!$diretoria->getByResponsavel($_SESSION['fmj.userId'])){
    $_SESSION['fmj.mensagem'] = 36;
    header("Location:admin_home-home");
    exit();
}
$idCat = $diretoria->id;
$post = new Post();

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                                    <h1>
                                        '.$diretoria->descricao.'
                                        <small>Pesquisa</small>
                                    </h1>
                                    <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_diretoria-posts"><i class="fa fa-comment"> </i> Posts</a></li>
                                        <li class="active">Pesquisa</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/diretoria/pesquisa.html");

$TPL->NOME_CATEGORIA = $diretoria->descricao;
$TPL->ID_CATEGORIA = $diretoria->id;
//$TPL->ID_CATEGORIA_HASH = $post->md5_encrypt($diretoria->id);
$TPL->show();