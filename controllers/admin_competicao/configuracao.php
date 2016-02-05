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

$TPL->TITULO = $obj->titulo;
$TPL->DESCRICAO = $obj->descricao;
$TPL->DATA = $obj->convdata($obj->dataEvento,"mtn");
$TPL->ID = $obj->id;
$TPL->dobra1 = $obj->dobra1;
$TPL->dobra2 = $obj->dobra2;
$TPL->dobra3 = $obj->dobra3;
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
    }else
       $TPL->SELECTED_CUSTA = '';
    $TPL->DESC_CUSTA = $value->titulo;
    $TPL->block("BLOCK_CUSTA");
}

$rs = $obj->listaClasses();

$obCla = new Classe();
$rsCat = $obCla->getRows(0,999,array(),array("ativo"=>"=1"));
foreach ($rsCat as $key => $value) {
    $TPL->ID_CLA = $value->id;
    $TPL->DESC_CLA = $value->descricao;
    $TPL->CHECK_CLA = '';
    foreach ($rs as $key2 => $grupo) {
        if($value->id == $grupo->classe->id)
            $TPL->CHECK_CLA = 'checked="checked"';
    }
    
    $TPL->block("BLOCK_CLA");
}

if($obj->competicao == 1){
    $TPL->block("BLOCK_COMPETICAO_JS");
    $TPL->block("BLOCK_COMPETICAO");
}
    

$TPL->show();
?>