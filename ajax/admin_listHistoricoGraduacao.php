<?php
$menu = 25;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/atleta/listHistorico.html");
$h = new HistoricoGraduacao();
$rs = $h->listaPorAtleta($_REQUEST['idAtleta']);
foreach ($rs as $key => $value) {
	$TPL->FAIXA = $value->graduacao->faixa;
	$TPL->DATA = $h->convdata($value->data,"mtn");
	$TPL->ID_HASH = $h->md5_encrypt($value->id);
	$TPL->block("BLOCK_ITEM_LISTA");
}
$TPL->show();

exit();
?>

