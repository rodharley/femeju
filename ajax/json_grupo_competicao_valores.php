<?php
header("Content-Type: application/json", true);
$menu = 0;
include("configuraAjaxSemLogin.php");

$obj = new GrupoCompeticao();
$lista = $obj->listar($_REQUEST['competicao'],$_REQUEST['graduacao'],$_REQUEST['categoria'],$_REQUEST['classe']);
if(count($lista) > 0){    
echo json_encode(array("graduacao"=>utf8_encode($lista[0]->graduacao->descricao),"categoria"=>utf8_encode($lista[0]->categoria->descricao),"classe"=>utf8_encode($lista[0]->classe->descricao),"id"=>$lista[0]->id,"valor"=>$lista[0]->valor,"valorDesc"=>"R$ ".$obj->money($lista[0]->valor, "atb"),"dobra"=>$lista[0]->valor+$lista[0]->dobra,"dobraDesc"=>"R$ ".$obj->money($lista[0]->valor+$lista[0]->dobra, "atb")));
}else{
echo json_encode(array("graduacao"=>"","categoria"=>"","classe"=>"","id"=>0,"valor"=>0,"valorDesc"=>"R$ ".$obj->money(0, "atb"),"dobra"=>0,"dobraDesc"=>"R$ ".$obj->money(0, "atb")));    
}
exit();
?>