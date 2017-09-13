<?php
header("Content-Type: application/json", true);
$menu = 31;
include("configuraAjax.php");
$obj = new PagamentoItem();
$obj->atualizarValorItem($_REQUEST['idItem'],$_REQUEST['valor']);
exit();
?>