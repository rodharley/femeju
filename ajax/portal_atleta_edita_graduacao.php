<?php
include("configuraAjaxSemLogin.php");
$TPL = new Template("../templates/portal/atleta/graduacao.html");
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
	
	if($selectedGrad == $value->id){
        $TPL->BELT_BTN = "primary";
        $TPL->BELT_IMG = "belt_icon_select.png";
    }else{
        $TPL->BELT_BTN = "default";
        $TPL->BELT_IMG = "belt_icon.png";
    }
	
	$TPL->block("BLOCK_BELT");
}
$TPL->show();
exit();
?>
