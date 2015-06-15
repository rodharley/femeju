<?php
header("Content-Type: application/json", true);
$menu = 0;
include("configuraAjax.php");
$academia= new Academia();
$academia->getRow(array("nome"=>"='".$_REQUEST['nome']."'"));
$cidade = new Cidade();
$arrayCidade = array();
if($academia->id != null){
    $cidades = $cidade->getRows(0,9999,array(),array("uf"=>"=".$academia->cidade->uf->id));
    $arrayCidade = $academia->objectToArray($cidades);
}
$arrayfinal = $academia->objectToArray($academia);
$arrayfinal['cidades'] = $arrayCidade;
echo json_encode($arrayfinal);
