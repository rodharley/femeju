<?php
$menu = 37;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Eventos
                        <small>Novo Evento</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="#"><i class="fa fa-trophy"> </i> Eventos</a></li>
                                         <li class="active">Novo Evento</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/competicao/nova_etapa1.html");
$obj = new Competicao();
$obCusta = new Custa();
$t = new TipoCampeonato(TipoCampeonato::ABERTO);
$TPL->ID_TIPO = $t->id;
$TPL->DESC_TIPO = $t->descricao;
$TPL->block("BLOCK_TIPO");
$t = new TipoCampeonato(TipoCampeonato::FECHADO);
$TPL->ID_TIPO = $t->id;
$TPL->DESC_TIPO = $t->descricao;
$TPL->block("BLOCK_TIPO");

//lista de custas
$rsCustas = $obCusta->getRows(0,999,array(),array("ativo"=>"=1","grupo"=>"=".GrupoCusta::COMPETICAO));
foreach ($rsCustas as $key => $value) {
	$TPL->ID_CUSTA = $value->id;
    $TPL->DESC_CUSTA = $value->titulo;
    $TPL->block("BLOCK_CUSTA");
}
$TPL->show();
?>