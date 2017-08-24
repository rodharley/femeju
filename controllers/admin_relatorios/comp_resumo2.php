<?php
$menu = 45;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$ocomp = new Competicao();
$oass = new Associacao();

include("includes/include.mensagem.php");

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Relatórios
                        <small>Eventos e Competições</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade-main"><i class="fa fa-trophy"> </i> Relatórios</a></li>
                                         <li class="active">Inscritos</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/relatorios/comp_resumo2.html");
$rs = $ocomp->listaTodas();
foreach ($rs as $key => $value) {
	$TPL->TITULO = $value->titulo;
	$TPL->ID = $value->id;
	$TPL->block("BLOCK_EVENTO");
}

$TPL->show();
?>