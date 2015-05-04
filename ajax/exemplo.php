<?php
$menu = 0;
include("configuraAjax.php");
$TPL = new Template("../templates/financeiro/ajax_valor_por_tipo.html");
$obj = new TabelaPreco();

if(isset($_REQUEST['valor'])){
	$TPL->valor =  $_REQUEST['valor'];
	$TPL->valorR =  $_REQUEST['valorR'];
}
if(isset($_REQUEST['idTipo'])){
switch ($_REQUEST['idTipo']) {
	case TipoCobranca::PROCESSO_MES:
		$TPL->block("BLOCK_OUTRO");
		break;
	case TipoCobranca::UNIDADE_PROCESSO:
		$TPL->block("BLOCK_OUTRO");
		break;
	case TipoCobranca::MENSAL:
		$TPL->block("BLOCK_MENSAL");
		break;
	
	default:
		$TPL->block("BLOCK_MENSAL");
		break;
}
}else{
	$TPL->block("BLOCK_MENSAL");
}
$TPL->show();
exit();
?>