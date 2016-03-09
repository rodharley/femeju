<?php
$menu = 25;
include("configuraAjax.php");
$grad = new Graduacao();
$h = new HistoricoGraduacao();
$TPL = new Template("../templates/admin/atleta/formHistorico.html");
$TPL->LABEL = "Incluir Histórico";
$TPL->ID_ATLETA = $_REQUEST['idAtleta'];
$TPL->ACAO = "incluirH";
$rsGrad = $grad->listaAtivas(); 
$idGradS = 0;
if(isset($_REQUEST['idHistorico'])){
	$h->getById($h->md5_decrypt($_REQUEST['idHistorico']));
	$TPL->ID_HIST = $h->id;
	$TPL->ACAO = "editarH";
	$TPL->LABEL = "Editar Histórico";
	$TPL->DATA = $h->convdata($h->data, "mtn");
	$idGradS = $h->graduacao->id;
}

foreach ($rsGrad as $key => $value) {
	$TPL->ID_GRADUACAO = $value->id;
	$TPL->LABEL_GRADUACAO = $value->faixa." ".$value->descricao;
	$TPL->SELECTED = $idGradS == $value->id ? "selected" : "";
	$TPL->block("BLOCK_GRADUACAO");
}



$TPL->show();
 

exit();
?>

