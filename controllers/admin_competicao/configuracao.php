<?php
$menu = 37;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Competições
                        <small>Configuração</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_competicao"><i class="fa fa-trophy"> </i> Competições</a></li>
                                         <li class="active">Configuração</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/competicao/configuracao.html");

$obj = new Competicao();
$obj->getById($obj->md5_decrypt($_REQUEST['id']));
$obCusta = new Custa();
$TPL->LOADING = $obj->carregando;
$TPL->TITULO = $obj->titulo;
$TPL->DESCRICAO = $obj->descricao;
$TPL->DATA = $obj->convdata($obj->dataEvento,"mtn");
$TPL->ID = $obj->id;
$TPL->checkedInscricaoOn = $obj->inscricaoAberta == 1 ? "checked" : "";
$TPL->checkedInscricaoOff = $obj->inscricaoAberta == 0 ? "checked" : "";
$TPL->checkedAtivo = $obj->ativo == 1 ? "checked" : "";
$TPL->checkedInativo = $obj->ativo == 0 ? "checked" : "";

$t = new TipoCampeonato(TipoCampeonato::ABERTO);
$TPL->ID_TIPO = $t->id;
$TPL->DESC_TIPO = $t->descricao;
$TPL->SELECTED_TIPO = $obj->tipo == TipoCampeonato::ABERTO ? "selected":"";
$TPL->block("BLOCK_TIPO");
$t = new TipoCampeonato(TipoCampeonato::FECHADO);
$TPL->ID_TIPO = $t->id;
$TPL->DESC_TIPO = $t->descricao;
$TPL->SELECTED_TIPO = $obj->tipo == TipoCampeonato::FECHADO ? "selected":"";
$TPL->block("BLOCK_TIPO");

//lista de custas
$rsCustas = $obCusta->getRows(0,999,array(),array("ativo"=>"=1","grupo"=>"=".GrupoCusta::COMPETICAO));
foreach ($rsCustas as $key => $value) {
    $TPL->ID_CUSTA = $value->id;
    if($value->id == $obj->custa->id){
        $TPL->SELECTED_CUSTA = 'selected="selected"';
        $TPL->VALOR_CUSTA = $obj->custa->valor;
    }else
       $TPL->SELECTED_CUSTA = '';
    $TPL->DESC_CUSTA = $value->titulo;
    $TPL->block("BLOCK_CUSTA");
}

$obCat = new CategoriaPeso();
$obCla = new Classe();
$obGra = new Graduacao();
$rsCat = $obCat->getRows(0,999,array(),array("ativo"=>"=1"));
foreach ($rsCat as $key => $value) {
    $TPL->ID_CAT = $value->id;
    $TPL->DESC_CAT = $value->descricao;
    $TPL->block("BLOCK_CAT");
}
$rsCat = $obCla->getRows(0,999,array(),array("ativo"=>"=1"));
foreach ($rsCat as $key => $value) {
    $TPL->ID_CLA = $value->id;
    $TPL->DESC_CLA = $value->descricao;
    $TPL->block("BLOCK_CLA");
}
$rsCat = $obGra->getRows(0,999,array(),array("bitAtivo"=>"=1"));
foreach ($rsCat as $key => $value) {
    $TPL->ID_GRA = $value->id;
    $TPL->DESC_GRA = $value->descricao;
	$TPL->block("BLOCK_GRA");
}


$TPL->show();
?>