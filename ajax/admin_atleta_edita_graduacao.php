<?php
$menu = 27;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/atleta/graduacao.html");
$objGrad = new Graduacao;
$date = new DateTime( $objGrad->convdata($_REQUEST['data'],'ntm')); // data e hora de nascimento
$selectedGrad = $_REQUEST['selected'];
$interval = $date->diff( new DateTime( ) ); // data e hora atual
$idade = $interval->format( '%Y');
$listaGrad = $objGrad->listaAtivasPorIdade($idade);
foreach ($listaGrad as $key => $value) {
    $TPL->BELT_COLOR = $value->imagem;   
    $TPL->BELT_NAME = $value->descricao;
    $TPL->BELT_FAIXA = $value->faixa;
    $TPL->BELT_ID = $value->id;
	$TPL->block("BLOCK_BELT");
}
$TPL->show();

exit();
?>
