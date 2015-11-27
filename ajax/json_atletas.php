<?php
header("Content-Type: application/json", true);
$menu = 0;
include("configuraAjax.php");
$pessoa= new Atleta();
$rs = $pessoa->pesquisarParaInscricao($_REQUEST['busca'],isset($_REQUEST['associacao']) ? $_REQUEST['associacao'] :"");
$lista = array();
foreach ($rs as $key => $value) {
	$a = array("id"=>$value->id,
	"value"=> utf8_encode($value->pessoa->nome),
	"info"=> utf8_encode($value->pessoa->sobrenome)
    );    
	array_push($lista,$a);
}
//$lista = $pessoa->objectToArray($rs);
$arrayfinal['results'] = $lista;
echo json_encode($arrayfinal);
