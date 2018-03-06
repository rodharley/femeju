<?php
$menu = 29;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Graduação
                        <small>Edição de Graduações</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_graduacao-main"><i class="fa fa-users"> </i> Graduação</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/graduacao/edit.html");
$obj = new graduacao();

$TPL->LABEL = "Incluir graduação";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$arrayMenusSelecionados = array();


if(isset($_REQUEST['id'])){
    $TPL->LABEL = "Editar graduação";
    $TPL->ACAO = "editar";    
    $obj->getById($obj->md5_decrypt($_REQUEST['id']));
	$TPL->id = $obj->id;
    $TPL->nome = $obj->descricao;
    $TPL->faixa = $obj->faixa;
	$TPL->ordem = $obj->ordem;
	$TPL->idadeMin = $obj->idadeMin;
	$TPL->carencia = $obj->carenciaMin;
	$TPL->ativosim = $obj->bitAtivo ? "checked" : "";
	$TPL->ativonao = !$obj->bitAtivo ? "checked" : ""; 
  $TPL->cor = $obj->imagem;
  $rs = $obj->listaClasses();
}

$obCla = new Classe();
$rsCat = $obCla->getRows(0,999,array(),array("ativo"=>"=1"));
foreach ($rsCat as $key => $value) {
    $TPL->ID_CLA = $value->id;
    $TPL->DESC_CLA = $value->descricao;
    $TPL->CHECK_CLA = '';
    if(isset($_REQUEST['id'])){
    foreach ($rs as $key2 => $grupo) {
        if($value->id == $grupo->classe->id)
            $TPL->CHECK_CLA = 'checked="checked"';
    }
	}
    $TPL->block("BLOCK_CLA");
}
$TPL->show();
?>