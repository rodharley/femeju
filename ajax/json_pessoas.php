<?php
header("Content-Type: application/json", true);
$menu = 0;
include("configuraAjax.php");
$pessoa= new Pessoa();
$rs = $pessoa->getRows(0,10,array("nome"=>"ASC"),array("nome"=>" like '%".$_REQUEST['busca']."%'"));
$lista = array();
foreach ($rs as $key => $value) {
	$a = array("id"=>$value->id,
	"value"=> utf8_encode($value->nome),
	"info"=> utf8_encode($value->sobrenome)
    );    
	array_push($lista,$a);
}
//$lista = $pessoa->objectToArray($rs);
$arrayfinal['results'] = $lista;
echo json_encode($arrayfinal);
