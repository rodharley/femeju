<?php
$menu = 25;
include("configuraAjax.php");
$objFoto = new AssociacaoFoto();
$objFoto->getById($_REQUEST['idImagem']);
$objFoto -> apagaImagem($objFoto -> imagem, "../img/associacoes/");
$objFoto->delete($_REQUEST['idImagem']);
exit();
?>

