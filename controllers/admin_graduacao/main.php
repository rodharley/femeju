<?php
$menu = 29;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$grad = new Graduacao();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Graduação
                        <small>Lista de Graduações</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_graduacao-main"><i class="fa fa-users"> </i> Graduação</a></li>
                                         <li class="active">Listar</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/graduacao/list.html");



$alist = $grad->getRows(0,9999,array("ordem"=>"ASC"));
$TPL->QUANTIDADE = count($alist);
foreach($alist as $key => $gradario){
	$TPL->ordem = $gradario->ordem;
	$TPL->ativo = $gradario->bitAtivo ? "Sim" : "Não";
	$TPL->colorSituacao = $gradario->bitAtivo ? "success" : "danger";	
	$TPL->nome = $gradario->faixa."-".$gradario->descricao;
	$TPL->ID_HASH = $grad->md5_encrypt($gradario->id);
	$TPL->block("BLOCK_ITEM_LISTA");
}

$TPL->show();
?>